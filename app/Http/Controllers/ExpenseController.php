<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\BusinessLocation;
use App\Contact;
use App\ExpenseCategory;
use App\TaxRate;
use App\Transaction;
use App\User;
use App\Utils\CashRegisterUtil;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Events\ExpenseCreatedOrModified;

class ExpenseController extends Controller
{
    /**
     * Constructor
     *
     * @param  TransactionUtil  $transactionUtil
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, CashRegisterUtil $cashRegisterUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
            'is_return' => 0, 'transaction_no' => '', ];
        $this->cashRegisterUtil = $cashRegisterUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('all_expense.access') && ! auth()->user()->can('view_own_expense')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $expenses = Transaction::leftJoin('expense_categories AS ec', 'transactions.expense_category_id', '=', 'ec.id')
                        ->leftJoin('expense_categories AS esc', 'transactions.expense_sub_category_id', '=', 'esc.id')
                        ->join(
                            'business_locations AS bl',
                            'transactions.location_id',
                            '=',
                            'bl.id'
                        )
                        ->leftJoin('tax_rates as tr', 'transactions.tax_id', '=', 'tr.id')
                        ->leftJoin('users AS U', 'transactions.expense_for', '=', 'U.id')
                        ->leftJoin('users AS usr', 'transactions.created_by', '=', 'usr.id')
                        ->leftJoin('contacts AS c', 'transactions.contact_id', '=', 'c.id')
                        ->leftJoin(
                            'transaction_payments AS TP',
                            'transactions.id',
                            '=',
                            'TP.transaction_id'
                        )
                        ->where('transactions.business_id', $business_id)
                        ->whereIn('transactions.type', ['expense', 'expense_refund'])
                        ->select(
                            'transactions.id',
                            'transactions.document',
                            'transaction_date',
                            'ref_no',
                            'ec.name as category',
                            'esc.name as sub_category',
                            'payment_status',
                            'additional_notes',
                            'final_total',
                            'transactions.is_recurring',
                            'transactions.recur_interval',
                            'transactions.recur_interval_type',
                            'transactions.recur_repetitions',
                            'transactions.subscription_repeat_on',
                            'bl.name as location_name',
                            DB::raw("CONCAT(COALESCE(U.surname, ''),' ',COALESCE(U.first_name, ''),' ',COALESCE(U.last_name,'')) as expense_for"),
                            DB::raw("CONCAT(tr.name ,' (', tr.amount ,' )') as tax"),
                            DB::raw('SUM(TP.amount) as amount_paid'),
                            DB::raw("CONCAT(COALESCE(usr.surname, ''),' ',COALESCE(usr.first_name, ''),' ',COALESCE(usr.last_name,'')) as added_by"),
                            'transactions.recur_parent_id',
                            'c.name as contact_name',
                            'transactions.type'
                        )
                        ->with(['recurring_parent', 'expense_details.location', 'expense_details.tax'])
                        ->groupBy('transactions.id');

            //Add condition for expense for,used in sales representative expense report & list of expense
            if (request()->has('expense_for')) {
                $expense_for = request()->get('expense_for');
                if (! empty($expense_for)) {
                    $expenses->where('transactions.expense_for', $expense_for);
                }
            }

            if (request()->has('contact_id')) {
                $contact_id = request()->get('contact_id');
                if (! empty($contact_id)) {
                    $expenses->where('transactions.contact_id', $contact_id);
                }
            }

            //Add condition for location,used in sales representative expense report & list of expense
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (! empty($location_id)) {
                    // Filter by transaction location OR expense_details location
                    $expenses->where(function($query) use ($location_id) {
                        $query->where('transactions.location_id', $location_id)
                              ->orWhereHas('expense_details', function($q) use ($location_id) {
                                  $q->where('expense_details.location_id', $location_id);
                              });
                    });
                }
            }

            //Add condition for expense category, used in list of expense,
            if (request()->has('expense_category_id')) {
                $expense_category_id = request()->get('expense_category_id');
                if (! empty($expense_category_id)) {
                    $expenses->where('transactions.expense_category_id', $expense_category_id);
                }
            }

            //Add condition for expense sub category, used in list of expense,
            if (request()->has('expense_sub_category_id')) {
                $expense_sub_category_id = request()->get('expense_sub_category_id');
                if (! empty($expense_sub_category_id)) {
                    $expenses->where('transactions.expense_sub_category_id', $expense_sub_category_id);
                }
            }

            //Add condition for start and end date filter, uses in sales representative expense report & list of expense
            if (! empty(request()->start_date) && ! empty(request()->end_date)) {
                $start = request()->start_date;
                $end = request()->end_date;
                $expenses->whereDate('transaction_date', '>=', $start)
                        ->whereDate('transaction_date', '<=', $end);
            }

            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $expenses->whereIn('transactions.location_id', $permitted_locations);
            }

            //Add condition for payment status for the list of expense
            if (request()->has('payment_status')) {
                $payment_status = request()->get('payment_status');
                if (! empty($payment_status)) {
                    $expenses->where('transactions.payment_status', $payment_status);
                }
            }

            $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);
            if (! $is_admin && ! auth()->user()->can('all_expense.access')) {
                $user_id = auth()->user()->id;
                $expenses->where(function ($query) use ($user_id) {
                    $query->where('transactions.created_by', $user_id)
                        ->orWhere('transactions.expense_for', $user_id);
                });
            }

            // Get location filter for details icon
            $location_filter_for_details = request()->get('location_id');
            
            return Datatables::of($expenses)
                ->addColumn('details', function ($row) use ($location_filter_for_details) {
                    if ($row->expense_details && $row->expense_details->count() > 0) {
                        // If location filter is active, check if any details match
                        if (!empty($location_filter_for_details)) {
                            $has_matching_location = $row->expense_details->contains(function ($detail) use ($location_filter_for_details) {
                                return $detail->location_id == $location_filter_for_details;
                            });
                            if ($has_matching_location) {
                                return '<i class="fa fa-plus-circle text-success cursor-pointer expense-details-toggle" data-id="'.$row->id.'" title="'.__('lang_v1.view_details').'"></i>';
                            }
                            return '';
                        }
                        
                        // No location filter - show icon if any details exist
                        return '<i class="fa fa-plus-circle text-success cursor-pointer expense-details-toggle" data-id="'.$row->id.'" title="'.__('lang_v1.view_details').'"></i>';
                    }
                    return '';
                })
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn(
                    'action',
                    '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                            data-toggle="dropdown" aria-expanded="false"> @lang("messages.actions")<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                        </button>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                    @if(auth()->user()->can("expense.edit"))
                        <li><a href="{{action(\'App\Http\Controllers\ExpenseController@edit\', [$id])}}"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                    @endif
                    @if($document)
                        <li><a href="{{ url(\'uploads/documents/\' . $document)}}" 
                        download=""><i class="fa fa-download" aria-hidden="true"></i> @lang("purchase.download_document")</a></li>
                        @if(isFileImage($document))
                            <li><a href="#" data-href="{{ url(\'uploads/documents/\' . $document)}}" class="view_uploaded_document"><i class="fas fa-file-image" aria-hidden="true"></i>@lang("lang_v1.view_document")</a></li>
                        @endif
                    @endif
                    @if(auth()->user()->can("expense.delete"))
                        <li>
                        <a href="#" data-href="{{action(\'App\Http\Controllers\ExpenseController@destroy\', [$id])}}" class="delete_expense"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                    @endif
                    <li class="divider"></li> 
                    @if($payment_status != "paid")
                        <li><a href="{{action([\App\Http\Controllers\TransactionPaymentController::class, \'addPayment\'], [$id])}}" class="add_payment_modal"><i class="fas fa-money-bill-alt" aria-hidden="true"></i> @lang("purchase.add_payment")</a></li>
                    @endif
                    <li><a href="{{action([\App\Http\Controllers\TransactionPaymentController::class, \'show\'], [$id])}}" class="view_payment_modal"><i class="fas fa-money-bill-alt" aria-hidden="true" ></i> @lang("purchase.view_payments")</a></li>
                    </ul></div>'
                )
                // Don't remove id - we need it for the details toggle
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final-total" data-currency_symbol="true" data-orig-value="@if($type=="expense_refund"){{-1 * $final_total}}@else{{$final_total}}@endif">@if($type=="expense_refund") - @endif @format_currency($final_total)</span>'
                )
                ->editColumn('transaction_date', '{{@format_datetime($transaction_date)}}')
                ->editColumn(
                    'payment_status',
                    '<a href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, \'show\'], [$id])}}" class="view_payment_modal payment-status" data-orig-value="{{$payment_status}}" data-status-name="{{__(\'lang_v1.\' . $payment_status)}}"><span class="label @payment_status($payment_status)">{{__(\'lang_v1.\' . $payment_status)}}
                        </span></a>'
                )
                ->addColumn('payment_due', function ($row) {
                    $due = $row->final_total - $row->amount_paid;

                    if ($row->type == 'expense_refund') {
                        $due = -1 * $due;
                    }

                    return '<span class="display_currency payment_due" data-currency_symbol="true" data-orig-value="'.$due.'">'.$this->transactionUtil->num_f($due, true).'</span>';
                })
                ->addColumn('recur_details', function ($row) {
                    $details = '<small>';
                    if ($row->is_recurring == 1) {
                        $type = $row->recur_interval == 1 ? Str::singular(__('lang_v1.'.$row->recur_interval_type)) : __('lang_v1.'.$row->recur_interval_type);
                        $recur_interval = $row->recur_interval.$type;

                        $details .= __('lang_v1.recur_interval').': '.$recur_interval;
                        if (! empty($row->recur_repetitions)) {
                            $details .= ', '.__('lang_v1.no_of_repetitions').': '.$row->recur_repetitions;
                        }
                        if ($row->recur_interval_type == 'months' && ! empty($row->subscription_repeat_on)) {
                            $details .= '<br><small class="text-muted">'.
                            __('lang_v1.repeat_on').': '.str_ordinal($row->subscription_repeat_on);
                        }
                    } elseif (! empty($row->recur_parent_id)) {
                        $details .= __('lang_v1.recurred_from').': '.$row->recurring_parent->ref_no;
                    }
                    $details .= '</small>';

                    return $details;
                })
                ->editColumn('ref_no', function ($row) {
                    $ref_no = $row->ref_no;
                    if (! empty($row->is_recurring)) {
                        $ref_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="'.__('lang_v1.recurring_expense').'"><i class="fas fa-recycle"></i></small>';
                    }

                    if (! empty($row->recur_parent_id)) {
                        $ref_no .= ' &nbsp;<small class="label bg-info label-round no-print" title="'.__('lang_v1.generated_recurring_expense').'"><i class="fas fa-recycle"></i></small>';
                    }

                    if ($row->type == 'expense_refund') {
                        $ref_no .= ' &nbsp;<small class="label bg-gray">'.__('lang_v1.refund').'</small>';
                    }

                    return $ref_no;
                })
                ->addColumn('expense_details', function ($row) {
                    // Format expense_details for JavaScript
                    if ($row->expense_details && $row->expense_details->count() > 0) {
                        return $row->expense_details->map(function ($detail) {
                            // Format location name to match dropdown format: name (location_id)
                            $location_name = null;
                            if ($detail->location) {
                                $location_name = $detail->location->name;
                                if (!empty($detail->location->location_id)) {
                                    $location_name .= ' (' . $detail->location->location_id . ')';
                                }
                            }
                            
                            return [
                                'location_id' => $detail->location_id,
                                'location' => $detail->location ? ['name' => $location_name] : null,
                                'tax_id' => $detail->tax_id,
                                'tax' => $detail->tax ? ['name' => $detail->tax->name, 'amount' => $detail->tax->amount] : null,
                                'amount' => $detail->amount,
                                'note' => $detail->note,
                            ];
                        })->toArray();
                    }
                    return [];
                })
                ->rawColumns(['final_total', 'action', 'payment_status', 'payment_due', 'ref_no', 'recur_details', 'details'])
                ->make(true);
        }

        $business_id = request()->session()->get('user.business_id');

        $categories = ExpenseCategory::where('business_id', $business_id)
                            ->whereNull('parent_id')
                            ->pluck('name', 'id');

        $users = User::forDropdown($business_id, false, true, true);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        $contacts = Contact::contactDropdown($business_id, false, false);

        $sub_categories = ExpenseCategory::where('business_id', $business_id)
                        ->whereNotNull('parent_id')
                        ->pluck('name', 'id')
                        ->toArray();

        return view('expense.index')
            ->with(compact('categories', 'business_locations', 'users', 'contacts', 'sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('expense.add')) {
            abort(403, 'Unauthorized action.');
        }


        \Log::emergency('ExpenseController@create');

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (! $this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\ExpenseController::class, 'index']));
        }

        $business_locations = BusinessLocation::forDropdown($business_id, false, true);

        $bl_attributes = $business_locations['attributes'];
        $business_locations = $business_locations['locations'];

        $expense_categories = ExpenseCategory::where('business_id', $business_id)
                                ->whereNull('parent_id')
                                ->pluck('name', 'id');
        $users = User::forDropdown($business_id, true, true);

        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);

        $payment_line = $this->dummyPaymentLine;

        $payment_types = $this->transactionUtil->payment_types(null, false, $business_id);

        $contacts = Contact::contactDropdown($business_id, false, false);

        //Accounts
        $accounts = [];
        if ($this->moduleUtil->isModuleEnabled('account')) {
            $accounts = Account::forDropdown($business_id, true, false, true);
        }

        if (request()->ajax()) {
            return view('expense.add_expense_modal')
                ->with(compact('expense_categories', 'business_locations', 'users', 'taxes', 'payment_line', 'payment_types', 'accounts', 'bl_attributes', 'contacts'));
        }

        return view('expense.create')
            ->with(compact('expense_categories', 'business_locations', 'users', 'taxes', 'payment_line', 'payment_types', 'accounts', 'bl_attributes', 'contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('expense.add')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');

            //Check if subscribed or not
            if (! $this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\ExpenseController::class, 'index']));
            }

            //Validate document size
            $request->validate([
                'document' => 'file|max:'.(config('constants.document_size_limit') / 1000),
            ]);

            // Validate expense_details - require at least one detail row
            $expense_details = $request->input('expense_details', []);
            
            // Filter out any empty entries (where both location_id and amount are empty)
            $valid_expense_details = array_filter($expense_details, function($detail) {
                return !empty($detail['location_id']) && !empty($detail['amount']);
            });
            
            // Require at least one valid expense detail
            if (empty($valid_expense_details)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['expense_details' => 'Please add at least one expense detail row with location and amount before submitting.'])
                    ->with('status', ['success' => 0, 'msg' => 'Please add at least one expense detail row before submitting.']);
            }
            
            // Validate the expense_details array structure
            $request->validate([
                'expense_details' => 'required|array|min:1',
                'expense_details.*.location_id' => 'required|integer',
                'expense_details.*.amount' => 'required|numeric|min:0.01',
                'expense_details.*.tax_id' => 'nullable|integer',
                'expense_details.*.note' => 'nullable|string|max:191',
            ], [
                'expense_details.required' => 'Please add at least one expense detail row.',
                'expense_details.min' => 'Please add at least one expense detail row.',
                'expense_details.*.location_id.required' => 'Location is required for each expense detail.',
                'expense_details.*.amount.required' => 'Amount is required for each expense detail.',
                'expense_details.*.amount.numeric' => 'Amount must be a valid number.',
                'expense_details.*.amount.min' => 'Amount must be greater than 0.',
            ]);

            $user_id = $request->session()->get('user.id');

            DB::beginTransaction();

            $expense = $this->transactionUtil->createExpense($request, $business_id, $user_id);

            if (request()->ajax()) {
                $payments = ! empty($request->input('payment')) ? $request->input('payment') : [];
                $this->cashRegisterUtil->addSellPayments($expense, $payments);
            }

            $this->transactionUtil->activityLog($expense, 'added');

            event(new ExpenseCreatedOrModified($expense));

            DB::commit();

            $output = ['success' => 1,
                'msg' => __('expense.expense_add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        if (request()->ajax()) {
            return $output;
        }

        return redirect('expenses')->with('status', $output);
    }

    /**
     * Get expense details for a specific expense
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getExpenseDetails($id)
    {
        if (! auth()->user()->can('all_expense.access') && ! auth()->user()->can('view_own_expense')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $expense = Transaction::where('business_id', $business_id)
                ->where('id', $id)
                ->with(['expense_details.location', 'expense_details.tax'])
                ->first();

            if (!$expense) {
                return response()->json([
                    'success' => false,
                    'msg' => __('messages.not_found'),
                    'expense_details' => [],
                ]);
            }

            // Get location filter from request
            $location_filter = request()->get('location_id');
            
            $expense_details = [];
            if ($expense->expense_details && $expense->expense_details->count() > 0) {
                // Filter by location if location filter is provided
                $filtered_details = $expense->expense_details;
                if (!empty($location_filter)) {
                    $filtered_details = $filtered_details->filter(function ($detail) use ($location_filter) {
                        return $detail->location_id == $location_filter;
                    });
                }
                
                $expense_details = $filtered_details->map(function ($detail) {
                    // Format location name to match dropdown format: name (location_id)
                    $location_name = null;
                    if ($detail->location) {
                        $location_name = $detail->location->name;
                        if (!empty($detail->location->location_id)) {
                            $location_name .= ' (' . $detail->location->location_id . ')';
                        }
                    }
                    
                    return [
                        'location_id' => $detail->location_id,
                        'location' => $detail->location ? ['name' => $location_name] : null,
                        'tax_id' => $detail->tax_id,
                        'tax' => $detail->tax ? ['name' => $detail->tax->name, 'amount' => $detail->tax->amount] : null,
                        'amount' => $detail->amount,
                        'note' => $detail->note,
                    ];
                })->values()->toArray();
            }

            return response()->json([
                'success' => true,
                'expense_details' => $expense_details,
            ]);
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            return response()->json([
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! auth()->user()->can('expense.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (! $this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\ExpenseController::class, 'index']));
        }

        $business_locations = BusinessLocation::forDropdown($business_id);

        $expense_categories = ExpenseCategory::where('business_id', $business_id)
                                ->whereNull('parent_id')
                                ->pluck('name', 'id');
        $expense = Transaction::where('business_id', $business_id)
                                ->where('id', $id)
                                ->with(['expense_details.location', 'expense_details.tax'])
                                ->first();

        $users = User::forDropdown($business_id, true, true);

        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);

        $contacts = Contact::contactDropdown($business_id, false, false);

        //Sub-category
        $sub_categories = [];

        if (! empty($expense->expense_category_id)) {
            $sub_categories = ExpenseCategory::where('business_id', $business_id)
                        ->where('parent_id', $expense->expense_category_id)
                        ->pluck('name', 'id')
                        ->toArray();
        }

        return view('expense.edit')
            ->with(compact('expense', 'expense_categories', 'business_locations', 'users', 'taxes', 'contacts', 'sub_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('expense.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            //Validate document size
            $request->validate([
                'document' => 'file|max:'.(config('constants.document_size_limit') / 1000),
            ]);

            $business_id = $request->session()->get('user.business_id');

            //Check if subscribed or not
            if (! $this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\ExpenseController::class, 'index']));
            }

            // Validate expense_details - require at least one detail row
            $expense_details = $request->input('expense_details', []);
            
            // Filter out any empty entries (where both location_id and amount are empty)
            $valid_expense_details = array_filter($expense_details, function($detail) {
                return !empty($detail['location_id']) && !empty($detail['amount']);
            });
            
            // Require at least one valid expense detail
            if (empty($valid_expense_details)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['expense_details' => 'Please add at least one expense detail row with location and amount before submitting.'])
                    ->with('status', ['success' => 0, 'msg' => 'Please add at least one expense detail row before submitting.']);
            }
            
            // Validate the expense_details array structure
            $request->validate([
                'expense_details' => 'required|array|min:1',
                'expense_details.*.location_id' => 'required|integer',
                'expense_details.*.amount' => 'required|numeric|min:0.01',
                'expense_details.*.tax_id' => 'nullable|integer',
                'expense_details.*.note' => 'nullable|string|max:191',
            ], [
                'expense_details.required' => 'Please add at least one expense detail row.',
                'expense_details.min' => 'Please add at least one expense detail row.',
                'expense_details.*.location_id.required' => 'Location is required for each expense detail.',
                'expense_details.*.amount.required' => 'Amount is required for each expense detail.',
                'expense_details.*.amount.numeric' => 'Amount must be a valid number.',
                'expense_details.*.amount.min' => 'Amount must be greater than 0.',
            ]);

            $expense = $this->transactionUtil->updateExpense($request, $id, $business_id);

            $this->transactionUtil->activityLog($expense, 'edited');

            event(new ExpenseCreatedOrModified($expense));

            $output = ['success' => 1,
                'msg' => __('expense.expense_update_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect('expenses')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('expense.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $expense = Transaction::where('business_id', $business_id)
                                        ->where(function ($q) {
                                            $q->where('type', 'expense')
                                                ->orWhere('type', 'expense_refund');
                                        })
                                        ->where('id', $id)
                                        ->first();

                //Delete Cash register transactions
                $expense->cash_register_payments()->delete();

                $expense->delete();

                //Delete account transactions
                AccountTransaction::where('transaction_id', $expense->id)->delete();

                event(new ExpenseCreatedOrModified($expense, true));

                $output = ['success' => true,
                    'msg' => __('expense.expense_delete_success'),
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }
}
