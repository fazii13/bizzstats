@extends('layouts.app')
@section('title', __('recipe.recipe_details'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('recipe.recipe_details')</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="form-group">
                        <label>@lang('recipe.name'):</label>
                        <p>{{ $recipe->name }}</p>
                    </div>
                    <div class="form-group">
                        <label>@lang('recipe.description'):</label>
                        <p>{{ $recipe->description }}</p>
                    </div>
                    <!-- Add fields as per your recipe details -->
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{ route('recipes.index') }}" class="btn btn-default">@lang('messages.back')</a>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@endsection
