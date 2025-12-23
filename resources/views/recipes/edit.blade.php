@extends('layouts.app')
@section('title', __('lang_v1.producation_edit'))
@section('css')
    <style>
        .total_cost {
            border: none;
        }
    </style>
@endsection
@section('content')

    <section class="content-header">
        <h1>@lang('lang_v1.producation_edit')</h1>
    </section>

    <section class="content">
        {!! Form::open([
            'url' => action([\App\Http\Controllers\RecipeController::class, 'update'], [$recipe->id]),
            'method' => 'PUT',
            'id' => 'recipe_edit_form',
            'class' => 'recipe_form',
        ]) !!}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @component('components.widget', ['class' => 'box-primary'])
        @dump($errors->all())
              
            <div class="row" id="recipe_fields_container">
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('recipe_name', __('recipes.recipe_name') . ':') !!}
                        {!! Form::text('recipe_name', $recipe->recipe_name, [
                            'class' => 'form-control',
                            'placeholder' => __('recipes.recipe_name'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('product_quantity', __('recipes.quantity') . ':') !!}
                        {!! Form::number('product_quantity', $recipe->product_quantity, [
                            'class' => 'form-control',
                            'placeholder' => __('recipes.quantity'),
                        ]) !!}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('product_type', __('product.product_type') . ':') !!}
                        {!! Form::select(
                            'product_type',
                            [
                                'raw_material' => __('Raw Material'),
                                'finished_goods' => __('Finished Goods'),
                                'packing_type' => __('Packing'),
                            ],
                            $recipe->product_type,
                            ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2'],
                        ) !!}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {!! Form::label('unit_id', __('product.unit') . ':*') !!}
                            {!! Form::select(
                                'unit_id',
                                $units,
                                $recipeProductUnitId->unit_id,
                                ['class' => 'form-control select2'],
                            ) !!}

                    </div>
                </div>




                <input type="hidden" name="location" class="location" value="{{$recipe->products[0]->product_locations[0]->id}}">
                @foreach ($recipe->products as $index => $product)
                    <div class="recipe_row col-sm-12">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="item_code">@lang('recipes.item_code') :*</label>
                                {!! Form::select('item_code[]', $product_codes, $product->sku, [
                                    'class' => 'form-control select2 item-code-dropdown',
                                    'required',
                                    'placeholder' => __('messages.please_select'),
                                    'onchange' => 'fetchProductDetails(this, "item_code")',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name">@lang('recipes.name') :*</label>
                                {!! Form::select('name[]', $product_names, $product->id, [
                                    'class' => 'form-control select2 product-name-dropdown',
                                    'required',
                                    'placeholder' => __('messages.please_select'),
                                    'onchange' => 'fetchProductDetails(this, "name")',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="qty">@lang('recipes.qty') :*</label>
                                <input type="number" name="qty[]" class="form-control qty-input"
                                    value="{{ $product->pivot->quantity }}" required placeholder="@lang('recipes.qty')">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rate">@lang('recipes.rate') :*</label>
                                <input type="text" name="rate[]" class="form-control rate-input"
                                    value="{{ $product->pivot->rate }}" required placeholder="@lang('recipes.rate')">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cost">@lang('recipes.cost') :*</label>
                                <input type="text" name="cost[]" class="form-control cost-input"
                                    value="{{ $product->pivot->cost }}" placeholder="@lang('recipes.cost')" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2" style="display:none">
                            <div class="form-group">
                                <label for="product_id">@lang('recipes.product_id') :*</label>
                                {!! Form::select('product_id[]', $product_ids, $product->id, [
                                    'class' => 'form-control select2 product-id-dropdown',
                                    'required',
                                    'placeholder' => __('messages.please_select'),
                                    'readonly',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-2" style="padding-top: 23px">
                            <button type="button" class="btn btn-danger remove_row_btn">X</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-sm-12">
                <button type="button" class="btn btn-primary" id="add_more_btn">+</button>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center">
                        <label for="product_id">Total Cost:</label>
                        {!! Form::text('total_cost', $recipe->products->sum('pivot.cost'), [
                            'id' => 'total_cost_input',
                            'class' => 'total_cost',
                            'readonly',
                        ]) !!}
                    </div>
                </div>
            </div>
        @endcomponent

        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>

@endsection

@section('javascript')
    @php $asset_v = env('APP_VERSION'); @endphp
    <script>
        function calculateCost() {
            var totalCost = 0;
            var productQuantity = parseFloat($('input[name="product_quantity"]').val()) || 1;

            $('.recipe_row').each(function() {
                var qty = parseFloat($(this).find('.qty-input').val()) || 0;
                var rate = parseFloat($(this).find('.rate-input').val()) || 0;
                var cost = qty * rate;
                totalCost += cost;
                $(this).find('.cost-input').val(Math.floor(cost)); // Use Math.floor to get only integer part
            });

            totalCost *= productQuantity;
            $('#total_cost_input').val(Math.floor(totalCost)); // Update the hidden input
        }
        // Initial calculation
        calculateCost();

        function bindEventListeners() {
            // Update cost when quantity or rate changes
            $('.qty-input, .rate-input').on('input', calculateCost);

            // Update cost when product quantity changes
            $('input[name="product_quantity"]').on('input', calculateCost);

            // Remove row and update cost
            $('#recipe_fields_container').on('click', '.remove_row_btn', function() {
                $(this).closest('.recipe_row').remove();
                calculateCost();
            });
        }

        // Initial event binding
        bindEventListeners();

        var productCodes = @json($product_codes);
        var productNames = @json($product_names);
        var productIds = @json($product_ids);

        function generateOptions(options) {
            return Object.keys(options).map(function(key) {
                return '<option value="' + key + '">' + options[key] + '</option>';
            }).join('');
        }

        var productCodeOptions = generateOptions(productCodes);
        var productNameOptions = generateOptions(productNames);
        var productIdOptions = generateOptions(productIds);
        $('#add_more_btn').click(function() {
            var newRow = `
                    <div class="recipe_row col-sm-12">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="item_code">@lang('recipes.item_code') :*</label>
                                <select name="item_code[]" class="form-control select2 item-code-dropdown" required onchange="fetchProductDetails(this, 'item_code')">
                                    <option value="">@lang('messages.please_select')</option>
                                    ${productCodeOptions}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name">@lang('recipes.name') :*</label>
                                <select name="name[]" class="form-control select2 product-name-dropdown" required onchange="fetchProductDetails(this, 'name')">
                                    <option value="">@lang('messages.please_select')</option>
                                    ${productNameOptions}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="qty">@lang('recipes.qty') :*</label>
                                <input type="number" name="qty[]" class="form-control qty-input" required placeholder="@lang('recipes.qty')">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rate">@lang('recipes.rate') :*</label>
                                <input type="text" name="rate[]" class="form-control rate-input" required placeholder="@lang('recipes.rate')">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="cost">@lang('recipes.cost') :*</label>
                                <input type="text" name="cost[]" class="form-control cost-input" placeholder="@lang('recipes.cost')" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2" style="display:none">
                            <div class="form-group">
                                <label for="product_id">@lang('recipes.product_id') :*</label>
                                <select name="product_id[]" class="form-control select2 product-id-dropdown" required readonly>
                                    <option value="">@lang('messages.please_select')</option>
                                    ${productIdOptions}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2" style="padding-top: 23px">
                            <button type="button" class="btn btn-danger remove_row_btn">X</button>
                        </div>
                    </div>
                `;
            $('#recipe_fields_container').append(newRow);
            $('.select2').select2();

            $('input[name="product_quantity"]').on('input', calculateCost);
            $('.rate-input').on('input', calculateCost);
            $('.qty-input').on('input', calculateCost);
        });
        $('#recipe_fields_container').on('click', '.remove_row_btn', function() {
            $(this).closest('.recipe_row').remove();
            calculateCost();
        });

        $(document).on('input', '.qty-input, .rate-input', function() {
            calculateCost();
        });

        $(document).on('change', '.product-name-dropdown', function() {
            var selectedProductId = $(this).val();
            var selectedItemCode = $(this).closest('.recipe_row').find('.item-code-dropdown');
            var selectedProductId = $(this).closest('.recipe_row').find('.product-id-dropdown');
            selectedItemCode.val(selectedProductId);
            selectedProductId.val(selectedProductId);
        });

        function fetchProductDetails(selectElement, field) {
            var productValue = $(selectElement).val(); // Get the selected value

            if (productValue) {
                $.ajax({
                    url: '/get-product-details/' + productValue,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            var product = response.product;
                            console.log('product', product);
                            
                            var $row = $(selectElement).closest('.recipe_row');

                            // Update fields based on the selected product
                            if (field === 'item_code') {
                                var nameSelect = $row.find('select[name="name[]"]');
                                if (nameSelect.find('option[value="' + product.name + '"]').length) {
                                    nameSelect.val(product.name).trigger('change.select2');
                                } else {
                                    var newOption = new Option(product.name, product.name, true, true);
                                    nameSelect.append(newOption).trigger('change.select2');
                                }
                                $row.find('input[name="rate[]"]').val(product.sell_price_inc_tax);
                                $row.find('input[name="cost[]"]').val(product.cost);
                                $('.location').val(product.product_location); 
                               
                                $row.find('select[name="product_id[]"]').val(product.id).trigger(
                                    'change.select2');
                            } else if (field === 'name') {
                                var codeSelect = $row.find('select[name="item_code[]"]');
                                if (codeSelect.find('option[value="' + product.sku + '"]').length) {
                                    codeSelect.val(product.sku).trigger('change.select2');
                                } else {
                                    var newOption = new Option(product.sku, product.sku, true, true);
                                    codeSelect.append(newOption).trigger('change.select2');
                                }
                                $row.find('input[name="rate[]"]').val(product.sell_price_inc_tax);
                                $row.find('input[name="cost[]"]').val(product.cost);
                                $('.location').val(product.product_location);
                                $row.find('select[name="product_id[]"]').val(product.id).trigger(
                                    'change.select2');
                            }

                            calculateCost(); // Recalculate cost if necessary
                        } else {
                            console.error('Error fetching product details:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                    }
                });
            }
        }
    </script>
    <script src="{{ asset('js/recipe.js?v=' . $asset_v) }}"></script>
@endsection
