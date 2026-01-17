<?php

namespace App\Http\Controllers;

use App\Account;
use App\BusinessLocation;
use App\Income;
use App\IncomeCategory;
use App\TaxRate;
use App\Transaction;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    /**
     * All Utils instance.
     *
     * @var ModuleUtil
     */
    protected $moduleUtil;

    /**
     * Transaction Util instance.
     *
     * @var TransactionUtil
     */
    protected $transactionUtil;

    /**
     * Dummy payment line for forms
     *
     * @var array
     */
    protected $dummyPaymentLine;

    /**
     * Constructor
     *
     * @param  ModuleUtil  $moduleUtil
     * @param  TransactionUtil  $transactionUtil
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil, TransactionUtil $transactionUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->transactionUtil = $transactionUtil;
        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
            'is_return' => 0, 'transaction_no' => '', ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('all_income.access') && ! auth()->user()->can('view_own_income')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $incomes = Income::leftJoin(
                                'business_locations AS bl',
                                'incomes.location_id',
                                '=',
                                'bl.id'
                            )
                            ->leftJoin('tax_rates as tr', 'incomes.tax_id', '=', 'tr.id')
                            ->leftJoin('users AS usr', 'incomes.created_by', '=', 'usr.id')
                            ->where('incomes.business_id', $business_id)
                            ->select(
                                'incomes.id',
                                'incomes.document',
                                'incomes.payment_date as transaction_date',
                                'incomes.ref_no',
                                'incomes.income_category_id',
                                'incomes.work_order_number',
                                'incomes.additional_notes',
                                'incomes.final_total',
                                'incomes.tax_amount',
                                'incomes.payment_method',
                                DB::raw('COALESCE(bl.name, "-") as location_name'),
                                DB::raw("COALESCE(CONCAT(tr.name ,' (', tr.amount ,'%)'), '-') as tax"),
                                DB::raw("COALESCE(CONCAT(COALESCE(usr.surname, ''),' ',COALESCE(usr.first_name, ''),' ',COALESCE(usr.last_name,'')), '-') as added_by")
                            );

            //Add condition for location
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (! empty($location_id)) {
                    $incomes->where('incomes.location_id', $location_id);
                }
            }

            //Add condition for start and end date filter
            if (! empty(request()->start_date) && ! empty(request()->end_date)) {
                $start = request()->start_date;
                $end = request()->end_date;
                $incomes->whereDate('incomes.payment_date', '>=', $start)
                        ->whereDate('incomes.payment_date', '<=', $end);
            }

            /** @var \App\User $user */
            $user = auth()->user();
            $permitted_locations = $user->permitted_locations();
            if ($permitted_locations != 'all') {
                $incomes->whereIn('incomes.location_id', $permitted_locations);
            }

            $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);
            if (! $is_admin && ! auth()->user()->can('all_income.access')) {
                $user_id = auth()->user()->id;
                $incomes->where('incomes.created_by', $user_id);
            }

            // Income categories mapping
            $income_categories = IncomeCategory::where('business_id', $business_id)
                                ->pluck('name', 'id')
                                ->toArray();

            return Datatables::of($incomes)
                ->addColumn(
                    'action',
                    '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                            data-toggle="dropdown" aria-expanded="false"> @lang("messages.actions")<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                        </button>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                    @if(auth()->user()->can("income.edit"))
                        <li><a href="{{action(\'App\Http\Controllers\IncomeController@edit\', [$id])}}"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                    @endif
                    @if($document)
                        <li><a href="{{ url(\'uploads/documents/\' . $document)}}" 
                        download=""><i class="fa fa-download" aria-hidden="true"></i> @lang("purchase.download_document")</a></li>
                        @if(isFileImage($document))
                            <li><a href="#" data-href="{{ url(\'uploads/documents/\' . $document)}}" class="view_uploaded_document"><i class="fas fa-file-image" aria-hidden="true"></i>@lang("lang_v1.view_document")</a></li>
                        @endif
                    @endif
                    @if(auth()->user()->can("income.delete"))
                        <li>
                        <a href="#" data-href="{{action(\'App\Http\Controllers\IncomeController@destroy\', [$id])}}" class="delete_income"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                    @endif
                    </ul></div>'
                )
                ->removeColumn('id')
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final-total" data-currency_symbol="true" data-orig-value="{{$final_total}}">@format_currency($final_total)</span>'
                )
                ->editColumn('transaction_date', '{{@format_datetime($transaction_date)}}')
                ->addColumn('category', function ($row) use ($income_categories) {
                    if (empty($row->income_category_id)) {
                        return '-';
                    }
                    return $income_categories[$row->income_category_id] ?? '-';
                })
                ->editColumn('payment_method', function ($row) {
                    $payment_types = [
                        'cash' => __('lang_v1.cash'),
                        'card' => __('lang_v1.card'),
                        'cheque' => __('lang_v1.cheque'),
                        'bank_transfer' => __('lang_v1.bank_transfer'),
                        'other' => __('lang_v1.other'),
                    ];
                    return $payment_types[$row->payment_method] ?? $row->payment_method;
                })
                ->editColumn('additional_notes', '{{$additional_notes ?? "-"}}')
                ->rawColumns(['final_total', 'action'])
                ->make(true);
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $business_id = request()->session()->get('user.business_id');
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('income.index')
            ->with(compact('business_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('income.add')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (! $this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\IncomeController::class, 'index']));
        }

        $business_locations = BusinessLocation::forDropdown($business_id, false, true);
        $bl_attributes = $business_locations['attributes'];
        $business_locations = $business_locations['locations'];

        $income_categories = IncomeCategory::where('business_id', $business_id)
                                ->pluck('name', 'id');

        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);

        $payment_line = $this->dummyPaymentLine;
        $payment_types = $this->transactionUtil->payment_types(null, false, $business_id);

        //Accounts
        $accounts = [];
        if ($this->moduleUtil->isModuleEnabled('account')) {
            $accounts = Account::forDropdown($business_id, true, false, true);
        }

        return view('income.create')
            ->with(compact('business_locations', 'bl_attributes', 'income_categories', 'taxes', 'payment_line', 'payment_types', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('income.add')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');

            //Check if subscribed or not
            if (! $this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\IncomeController::class, 'index']));
            }

            //Validate document size
            $request->validate([
                'document' => 'file|max:'.(config('constants.document_size_limit') / 1000),
                'location_id' => 'required',
                'income_category_id' => 'required',
                'final_total' => 'required|numeric',
                'payment_date' => 'required',
                'payment_method' => 'required',
            ]);

            $user_id = $request->session()->get('user.id');

            DB::beginTransaction();

            $income = $this->transactionUtil->createIncome($request, $business_id, $user_id);

            DB::commit();

            $output = ['success' => 1,
                'msg' => __('income.income_add_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        if (request()->ajax()) {
            return $output;
        }

        return redirect('income')->with('status', $output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! auth()->user()->can('income.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Check if subscribed or not
        if (! $this->moduleUtil->isSubscribed($business_id)) {
            return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\IncomeController::class, 'index']));
        }

        $income = Income::where('business_id', $business_id)
                        ->findOrFail($id);

        $business_locations = BusinessLocation::forDropdown($business_id, false, true);
        $bl_attributes = $business_locations['attributes'];
        $business_locations = $business_locations['locations'];

        $income_categories = IncomeCategory::where('business_id', $business_id)
                                ->pluck('name', 'id');

        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);

        $payment_line = $this->dummyPaymentLine;
        $payment_types = $this->transactionUtil->payment_types(null, false, $business_id);

        //Accounts
        $accounts = [];
        if ($this->moduleUtil->isModuleEnabled('account')) {
            $accounts = Account::forDropdown($business_id, true, false, true);
        }

        return view('income.edit')
            ->with(compact('income', 'business_locations', 'bl_attributes', 'income_categories', 'taxes', 'payment_line', 'payment_types', 'accounts'));
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
        if (! auth()->user()->can('income.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');

            //Check if subscribed or not
            if (! $this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action([\App\Http\Controllers\IncomeController::class, 'index']));
            }

            //Validate document size
            $request->validate([
                'document' => 'file|max:'.(config('constants.document_size_limit') / 1000),
                'location_id' => 'required',
                'income_category_id' => 'required',
                'final_total' => 'required|numeric',
                'payment_date' => 'required',
                'payment_method' => 'required',
            ]);

            DB::beginTransaction();

            $income = $this->transactionUtil->updateIncome($request, $id, $business_id);

            DB::commit();

            $output = ['success' => 1,
                'msg' => __('income.income_update_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect('income')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('income.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $income = Income::where('business_id', $business_id)
                                ->findOrFail($id);

                $income->delete();

                $output = ['success' => true,
                    'msg' => __('income.income_delete_success'),
                ];
            } catch (\Exception $e) {
                Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }
}
