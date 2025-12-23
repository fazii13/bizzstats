<?php

namespace App\Http\Controllers\Restaurant;

use App\Product;
use App\Utils\ProductUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ModifierSetsController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $productUtil;

    /**
     * Constructor
     *
     * @param  ProductUtils  $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil)
    {
        $this->productUtil = $productUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $modifer_set = Product::where('business_id', $business_id)
                            ->where('type', 'modifier')
                            ->with(['variations', 'modifier_products']);

            return \Datatables::of($modifer_set)
                ->addColumn(
                    'action',
                    '
                    @can("product.update")
                        <button type="button" data-href="{{action(\'App\Http\Controllers\Restaurant\ModifierSetsController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_modifier_button" data-container=".modifier_modal"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                        <button type="button" data-href="{{action(\'App\Http\Controllers\Restaurant\ProductModifierSetController@edit\', [$id])}}" class="btn btn-xs btn-info edit_modifier_button" data-container=".modifier_modal"><i class="fa fa-cubes"></i> @lang("restaurant.manage_products")</button>
                    &nbsp;
                    @endcan

                    @can("product.delete")
                        <button data-href="{{action(\'App\Http\Controllers\Restaurant\ModifierSetsController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_modifier_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan
                    '
                )
                ->editColumn('modifier_products', function ($row) {
                    $products = [];
                    foreach ($row->modifier_products as $product) {
                        $products[] = $product->name;
                    }

                    return implode(',  ', $products);
                })
                ->editColumn('variations', function ($row) {
                    $modifiers = [];
                    foreach ($row->variations as $modifier) {
                        $modifiers[] = $modifier->name;
                    }

                    return implode(', ', $modifiers);
                })
                ->removeColumn('id')
                ->escapeColumns(['action'])
                ->make(true);
        }

        return view('restaurant.modifier_sets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (! auth()->user()->can('product.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('restaurant.modifier_sets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('restaurant.modifier_sets.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */

}
