<?php

namespace App\Http\Controllers\Restaurant;

use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductModifierSetController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $modifer_set = Product::where('business_id', $business_id)
                        ->where('type', 'modifier')
                        ->where('id', $id)
                        ->with(['modifier_products'])
                        ->first();

            return view('restaurant.product_modifier_set.edit')
                ->with(compact('modifer_set'));
        }
    }

   



}
