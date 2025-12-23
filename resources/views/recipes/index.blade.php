@extends('layouts.app')

@section('title', __('lang_v1.list_recipes'))

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('lang_v1.list_recipes')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="box box-primary">
        @if (auth()->user()->can('producation.create')) 
          
            <div class="box-header with-border">
                <a href="{{ route('producations.create') }}" class="btn btn-primary">@lang('lang_v1.producation_add')</a>
            </div>
        @endif
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('recipes.recipe_id')</th>
                            <th>Product</th>
                            <th>@lang('recipes.cost')</th>
                            <th>@lang('recipes.product_qty')</th>
                            <th>@lang('messages.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distinctRecipes as $key => $recipe)
                            <!-- Display recipe details once -->
                            <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $recipe->recipe_name }}</td>
                                        <td>{{ $recipe->total_cost ?? '' }}</td>
                                        <td>{{ $recipe->product_quantity ?? '' }}</td>
                                        {{-- @if ($index === 0) --}}
                                            <td >
                                                @if (auth()->user()->can('producation.update')) 
                                                <a href="{{ route('producations.edit', $recipe->id) }}" class="btn btn-warning btn-sm">@lang('messages.edit')</a>
                                               @endif
                                                @if (auth()->user()->can('producation.delete')) 
                                                <form action="{{ route('producations.destroy', $recipe->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this producation?')">@lang('messages.delete')</button>
                                                </form>
                                                @endif
                                            </td>
                                        {{-- @endif --}}
                                 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->

@endsection
