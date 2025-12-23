<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\Product;
use App\ProductVariation;
use App\PurchaseLine;
use App\Transaction;
use App\TransactionSellLine;
use App\Unit;
use App\Variation;
use App\VariationLocationDetails;
use Carbon\Carbon;

use function PHPSTORM_META\type;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::with('products')->orderBy('id', 'desc')->get();

        $distinctRecipes = $recipes->unique('id');



        return view('recipes.index', compact('distinctRecipes'));
    }

    public function create()
    {
        $products = Product::all();

        $product_codes = $products->pluck('sku', 'sku')->toArray();
        $product_names = $products->pluck('name', 'id')->toArray();
        $product_ids = $products->pluck('id', 'id')->toArray();
        $units = Unit::pluck('actual_name', 'id')->all();


        return view('recipes.create', compact('products', 'units', 'product_codes', 'product_names', 'product_ids'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'recipe_name' => 'required|string',
            'product_quantity' => 'required|integer',
            'product_type' => 'required|string',
            'item_code' => 'required|array',
            'item_code.*' => 'required|string',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric',
            'rate' => 'required|array',
            'rate.*' => 'required|numeric',
            'total_cost' => 'nullable|numeric',
            'cost' => 'nullable|array',
            'cost.*' => 'nullable|numeric',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
        ]);

        $unit_id = $request->unit_id;

        $grand_total = $request['total_cost'] * $request['product_quantity'];

        $per_unit_price = $request['total_cost'] / $request['product_quantity'];

        try {
            $recipe = Recipe::create([
                'recipe_name' => $request->recipe_name,
                'product_type' => $request->product_type,
                'product_quantity' => $request->product_quantity,
                'total_cost' => $request->total_cost,
                'grand_total' => $grand_total,

            ]);

            $purchaseLineData = [];

            foreach ($request->product_id as $index => $productId) {
                // Fetch the first product detail from the recipe relationship
                
                // Fetch variation IDs associated with the product
                $ingredientVariations = Variation::where('product_id', $productId)->pluck('id')->toArray();
                
                // Attach product details to the recipe with related data
                $recipe->products()->attach($productId, [
                    'quantity' => $request->qty[$index],
                    'item_code' => $request->item_code[$index],
                    'name' => $request->name[$index],
                    'rate' => $request->rate[$index],
                    'cost' => $request->cost[$index],
                ]);

                $firstProductDetail = $recipe->products()->first();
            
            
                // Update product stock quantity for the specified location
                $productStock = VariationLocationDetails::where('product_id', $productId)
                    ->where('location_id', $request->location)
                    ->first();
            
                if ($productStock) {
                    $productStock->decrement('qty_available', $request->qty[$index]);
                }
            
                // Prepare data for purchase line
                $purchaseLineData = [
                    'product_id' => $productId,
                    'quantity' => $request->qty[$index],
                    'purchase_price' => $request->rate[$index] ?? $per_unit_price,
                    'purchase_price_inc_tax' => $request->cost[$index] ?? $per_unit_price,
                    'item_code' => $request->item_code[$index],
                    'variation_id' => $ingredientVariations[0] ?? null, 
                ];
            
                // Create dummy product variation for the purchase line
                $ingredientProductVariation = ProductVariation::create([
                    'name' => 'DUMMY',
                    'product_id' => $purchaseLineData['product_id'],
                    'is_dummy' => 1,
                ]);
            
                // Ensure that the variation was created successfully
                if (!$ingredientProductVariation) {
                    // Handle error if variation creation fails
                    throw new Exception('Failed to create product variation.');
                }
            
                // Create a transaction for each purchase line data entry
                $transaction = Transaction::create([
                    'business_id' => $firstProductDetail->business_id,
                    'location_id' => $request->location,
                    'type' => 'sell',
                    'status' => 'final',
                    'payment_status' => 'paid',
                    'recipe_id' => $recipe->id,
                    'ref_no' => $this->generateReferenceNumber(),
                    'invoice_no' => $this->generateReferenceNumber(),
                    'is_direct_sale' => 1,
                    'recur_interval' => 1,
                    'recur_interval_type' => 'days',
                    'transaction_date' => Carbon::now(),
                    'total_before_tax' => $purchaseLineData['purchase_price'],
                    'final_total' => $purchaseLineData['purchase_price'],
                    'created_by' => auth()->user()->id,
                ]);
            
                // Create variation location details for each purchase line
                VariationLocationDetails::create([
                    'product_id' => $purchaseLineData['product_id'],
                    'product_variation_id' => $ingredientProductVariation->id,
                    'variation_id' => $purchaseLineData['variation_id'], // Assign the variation_id
                    'qty_available' => $purchaseLineData['quantity'],
                    'location_id' => $request->location,
                ]);
            
                // Create transaction sell line for each variation
                TransactionSellLine::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $purchaseLineData['product_id'],
                    'variation_id' => $purchaseLineData['variation_id'], // Assign the variation_id
                    'quantity' => $purchaseLineData['quantity'],
                    'unit_price_before_discount' => $purchaseLineData['purchase_price'],
                    'unit_price' => $purchaseLineData['purchase_price'],
                    'unit_price_inc_tax' => $purchaseLineData['purchase_price'],
                ]);
            }

            $firstProductDetails = $recipe->products()->first();
            $userID = auth()->user()->id;
            $sku = $this->generateUniqueSku();

            $product = Product::create([
                'recipe_id' =>  $recipe->id,
                'name' => $request->recipe_name,
                'sku' => $sku,
                'product_scope' => $request->product_type,
                'business_id' => $firstProductDetails->business_id,
                'type' => $firstProductDetails->type,
                'unit_id' => $unit_id,
                'brand_id' => $firstProductDetails->brand_id,
                'is_inactive' => $firstProductDetails->is_inactive,
                'tax_type' => 'exclusive',
                'enable_stock' => 1,
                'alert_quantity' => $request->product_quantity,
                'created_by' => $userID,
            ]);

            $productVariation = ProductVariation::create([
                'name' => 'DUMMY',
                'product_id' => $product->id,
                'is_dummy' => 1,
            ]);

            $variation = Variation::create([
                'name' => 'DUMMY',
                'product_id' => $product->id,
                'product_variation_id' => $productVariation->id,
                'sub_sku' => $sku,
                'dpp_inc_tax' =>  $per_unit_price,
                'sell_price_inc_tax' => $request->total_cost,
            ]);


            $VariationLocationDetails = VariationLocationDetails::create([
                'product_id' => $product->id,
                'product_variation_id' => $productVariation->id,
                'variation_id' => $variation->id,
                'qty_available' =>  $request->product_quantity,
                'location_id' =>  $request->location,
            ]);

            $transaction = Transaction::create([
                'business_id' => $firstProductDetails->business_id,
                'location_id' =>  $request->location,
                'type' => 'sell',
                'recipe_id' =>  $recipe->id,
                'status' => 'final',
                'payment_status' => 'paid',
                'ref_no' =>  $this->generateReferenceNumber(),
                'transaction_date' => Carbon::now(),
                'total_before_tax' => $request->total_cost,
                'final_total' => $request->total_cost,
                'created_by' => auth()->user()->id,

            ]);

            TransactionSellLine::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'variation_id' => $variation->id,
                'quantity' =>  $request->product_quantity,
                'unit_price_before_discount' =>  $per_unit_price,
                'unit_price' =>  $per_unit_price,
                'unit_price_inc_tax' =>  $per_unit_price,

            ]);


            return redirect()->route('producations.index')->with('success', 'Producation has been saved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error saving the producations: ' . $e->getMessage());
        }
    }

    private function generateReferenceNumber()
{
    $year = date('Y');
    $lastTransaction = Transaction::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
    $newRefNo = $lastTransaction ? str_pad(intval(substr($lastTransaction->ref_no, -4)) + 1, 4, '0', STR_PAD_LEFT) : '0001';
    return 'Inv#' . $year . '/' . $newRefNo;
}

    public function edit($id)
    {
        $recipe = Recipe::with('products')->findOrFail($id);
        $products = Product::all();

        $recipeProductUnitId = Product::where('recipe_id', $recipe->id)->first('unit_id');

        $product_codes = $products->pluck('sku', 'sku')->toArray();
        $product_names = $products->pluck('name', 'id')->toArray();
        $product_ids = $products->pluck('id', 'id')->toArray();
        $units = Unit::pluck('actual_name', 'id')->all();

        return view('recipes.edit', compact('recipe', 'recipeProductUnitId', 'units', 'products', 'product_codes', 'product_names', 'product_ids'));
    }

    
    public function update(Request $request, $id)
{
    $request->validate([
        'recipe_name' => 'required|string',
        'product_quantity' => 'required|integer',
        'product_type' => 'required|string',
        'item_code' => 'required|array',
        'item_code.*' => 'required|string',
        'name' => 'required|array',
        'name.*' => 'required|string',
        'qty' => 'required|array',
        'qty.*' => 'required|numeric',
        'rate' => 'required|array',
        'rate.*' => 'required|numeric',
        'total_cost' => 'nullable|numeric',
        'cost' => 'nullable|array',
        'cost.*' => 'nullable|numeric',
        'product_id' => 'required|array',
        'product_id.*' => 'required|exists:products,id',
    ]);

    $unit_id = $request->unit_id;

    $grand_total = $request['total_cost'] * $request['product_quantity'];

    $per_unit_price = $request['total_cost'] / $request['product_quantity'];

    try {
        // Find the recipe to update
        $recipe = Recipe::findOrFail($id);

        $recipe->update([
            'recipe_name' => $request->recipe_name,
            'product_type' => $request->product_type,
            'product_quantity' => $request->product_quantity,
            'total_cost' => $request->total_cost,
            'grand_total' => $grand_total,
        ]);

        // Detach existing products
        $recipe->products()->detach();

        foreach ($request->product_id as $index => $productId) {
            // Fetch variation IDs associated with the product
            $ingredientVariations = Variation::where('product_id', $productId)->pluck('id')->toArray();
            
            // Attach product details to the recipe with related data
            $recipe->products()->attach($productId, [
                'quantity' => $request->qty[$index],
                'item_code' => $request->item_code[$index],
                'name' => $request->name[$index],
                'rate' => $request->rate[$index],
                'cost' => $request->cost[$index],
            ]);

            $firstProductDetail = $recipe->products()->first();
        
            // Update product stock quantity for the specified location
            $productStock = VariationLocationDetails::where('product_id', $productId)
                ->where('location_id', $request->location)
                ->first();
        
            if ($productStock) {
                $productStock->decrement('qty_available', $request->qty[$index]);
            }
        
            // Prepare data for purchase line
            $purchaseLineData = [
                'product_id' => $productId,
                'quantity' => $request->qty[$index],
                'purchase_price' => $request->rate[$index] ?? $per_unit_price,
                'purchase_price_inc_tax' => $request->cost[$index] ?? $per_unit_price,
                'item_code' => $request->item_code[$index],
                'variation_id' => $ingredientVariations[0] ?? null, 
            ];
        
            // Create or update product variation for the purchase line
            $ingredientProductVariation = ProductVariation::updateOrCreate([
                'product_id' => $purchaseLineData['product_id'],
                'is_dummy' => 1,
            ], [
                'name' => 'DUMMY',
            ]);
        
            // Create a transaction for each purchase line data entry
            $transaction = Transaction::updateOrCreate([
                'recipe_id' => $recipe->id,
                'type' => 'sell',
                'location_id' => $request->location,
                'status' => 'final',
                'payment_status' => 'paid',
            ], [
                'business_id' => $firstProductDetail->business_id,
                'ref_no' => $this->generateReferenceNumber(),
                'invoice_no' => $this->generateReferenceNumber(),
                'is_direct_sale' => 1,
                'recur_interval' => 1,
                'recur_interval_type' => 'days',
                'transaction_date' => Carbon::now(),
                'total_before_tax' => $purchaseLineData['purchase_price'],
                'final_total' => $purchaseLineData['purchase_price'],
                'created_by' => auth()->user()->id,
            ]);
        
            // Create or update variation location details for each purchase line
            VariationLocationDetails::updateOrCreate([
                'product_id' => $purchaseLineData['product_id'],
                'product_variation_id' => $ingredientProductVariation->id,
                'variation_id' => $purchaseLineData['variation_id'],
                'location_id' => $request->location,
            ], [
                'qty_available' => $purchaseLineData['quantity'],
            ]);
        
            // Create or update transaction sell line for each variation
            TransactionSellLine::updateOrCreate([
                'transaction_id' => $transaction->id,
                'product_id' => $purchaseLineData['product_id'],
                'variation_id' => $purchaseLineData['variation_id'],
            ], [
                'quantity' => $purchaseLineData['quantity'],
                'unit_price_before_discount' => $purchaseLineData['purchase_price'],
                'unit_price' => $purchaseLineData['purchase_price'],
                'unit_price_inc_tax' => $purchaseLineData['purchase_price'],
            ]);
        }

        $firstProductDetails = $recipe->products()->first();
        $userID = auth()->user()->id;

        // Create or update product
        $product = Product::updateOrCreate([
            'recipe_id' =>  $recipe->id,
        ], [
            'name' => $request->recipe_name,
            'sku' => $this->generateUniqueSku(),
            'product_scope' => $request->product_type,
            'business_id' => $firstProductDetails->business_id,
            'type' => $firstProductDetails->type,
            'unit_id' => $unit_id,
            'brand_id' => $firstProductDetails->brand_id,
            'is_inactive' => $firstProductDetails->is_inactive,
            'tax_type' => 'exclusive',
            'enable_stock' => 1,
            'alert_quantity' => $request->product_quantity,
            'created_by' => $userID,
        ]);

        $productVariation = ProductVariation::updateOrCreate([
            'product_id' => $product->id,
            'is_dummy' => 1,
        ], [
            'name' => 'DUMMY',
        ]);

        $variation = Variation::updateOrCreate([
            'product_id' => $product->id,
            'product_variation_id' => $productVariation->id,
        ], [
            'name' => 'DUMMY',
            'sub_sku' => $product->sku,
            'dpp_inc_tax' =>  $per_unit_price,
            'sell_price_inc_tax' => $request->total_cost,
        ]);


        VariationLocationDetails::updateOrCreate([
            'product_id' => $product->id,
            'product_variation_id' => $productVariation->id,
            'variation_id' => $variation->id,
            'location_id' => $request->location,
        ], [
            'qty_available' =>  $request->product_quantity,
        ]);

        $transaction = Transaction::updateOrCreate([
            'recipe_id' => $recipe->id,
            'location_id' => $request->location,
        ], [
            'business_id' => $firstProductDetails->business_id,
            'type' => 'sell',
            'status' => 'final',
            'payment_status' => 'paid',
            'ref_no' => $this->generateReferenceNumber(),
            'transaction_date' => Carbon::now(),
            'total_before_tax' => $request->total_cost,
            'final_total' => $request->total_cost,
            'created_by' => auth()->user()->id,
        ]);

        TransactionSellLine::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
        ], [
            'quantity' =>  $request->product_quantity,
            'unit_price_before_discount' =>  $per_unit_price,
            'unit_price' =>  $per_unit_price,
            'unit_price_inc_tax' =>  $per_unit_price,
        ]);

        return redirect()->route('producations.index')->with('success', 'Producation has been updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'There was an error updating the producations: ' . $e->getMessage());
    }
}














    public function getProductDetails($id)
    {
        $product = Product::with(['variations', 'product_locations'])
            ->where('id', $id)
            ->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        $variation = $product->variations->first();
        $sellPriceIncTax = $variation ? $variation->sell_price_inc_tax : 0;

        $product_location = $product->product_locations[0]->id;

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'cost' => $product->cost,
                'sell_price_inc_tax' => $sellPriceIncTax,
                'product_location' => $product_location,
            ],
        ]);
    }



    public function destroy($id)
    {
        try {
            // Find the recipe by ID
            $recipe = Recipe::findOrFail($id);

            // Detach associated products
            $recipe->products()->detach();

            // Delete the recipe
            $recipe->delete();

            return redirect()->route('producations.index')->with('success', 'Producation has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('producations.index')->with('error', 'There was an error deleting the recipe: ' . $e->getMessage());
        }
    }

    private function generateUniqueSku()
    {
        do {
            $sku = mt_rand(1000, 9999);
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }
}
