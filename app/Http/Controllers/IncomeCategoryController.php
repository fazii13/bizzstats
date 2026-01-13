<?php

namespace App\Http\Controllers;

use App\IncomeCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IncomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $income_category = IncomeCategory::where('business_id', $business_id)
                                                ->select(['name', 'code', 'id']);

            return Datatables::of($income_category)
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn(
                    'action',
                    '<button data-href="{{action(\'App\Http\Controllers\IncomeCategoryController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container=".income_category_modal"><i class="glyphicon glyphicon-edit"></i>  @lang("messages.edit")</button>
                        &nbsp;
                        <button data-href="{{action(\'App\Http\Controllers\IncomeCategoryController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_income_category"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>'
                )
                ->removeColumn('id')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('income_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        return view('income_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'code']);
            $input['business_id'] = $request->session()->get('user.business_id');

            IncomeCategory::create($input);
            $output = ['success' => true,
                'msg' => __('income.category_added_success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IncomeCategory  $incomeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeCategory $incomeCategory)
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
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $income_category = IncomeCategory::where('business_id', $business_id)->find($id);

            return view('income_category.edit')
                    ->with(compact('income_category'));
        }
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
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'code']);
                $business_id = $request->session()->get('user.business_id');

                $income_category = IncomeCategory::where('business_id', $business_id)->findOrFail($id);
                $income_category->name = $input['name'];
                $income_category->code = $input['code'];
                $income_category->save();

                $output = ['success' => true,
                    'msg' => __('income.category_updated_success'),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! (auth()->user()->can('income.add') || auth()->user()->can('income.edit'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $income_category = IncomeCategory::where('business_id', $business_id)->findOrFail($id);
                $income_category->delete();

                $output = ['success' => true,
                    'msg' => __('income.category_deleted_success'),
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
