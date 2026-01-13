@extends('layouts.app')
@section('title', __('income.edit_income'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('income.edit_income')</h1>
</section>

<!-- Main content -->
<section class="content">
	{!! Form::open(['url' => action([\App\Http\Controllers\IncomeController::class, 'update'], [$income->id]), 'method' => 'PUT', 'id' => 'add_income_form', 'files' => true ]) !!}
	<div class="box box-solid">
		<div class="box-body">
			<div class="row">

				@if(count($business_locations) == 1)
					@php 
						$default_location = current(array_keys($business_locations->toArray())) 
					@endphp
				@else
					@php $default_location = $income->location_id; @endphp
				@endif

				<!-- Row 1: Business Location, Income Category, Work Order Number -->
				<!-- Business Location -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('location_id', __('purchase.business_location').':*') !!}
						{!! Form::select('location_id', $business_locations, $income->location_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required'], $bl_attributes); !!}
					</div>
				</div>

				<!-- Income Category -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('income_category_id', __('income.income_category').':*') !!}
						{!! Form::select('income_category_id', $income_categories, $income->income_category_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
					</div>
				</div>

				<!-- Work Order Number -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('work_order_number', __('lang_v1.work_order_number').':') !!}
						{!! Form::text('work_order_number', $income->work_order_number, ['class' => 'form-control', 'placeholder' => __('lang_v1.work_order_number')]); !!}
					</div>
				</div>

				<div class="clearfix"></div>

				<!-- Row 2: Reference, Payment Date -->
				<!-- Reference -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('ref_no', __('purchase.ref_no').':') !!}
						{!! Form::text('ref_no', $income->ref_no, ['class' => 'form-control']); !!}
						<p class="help-block">
			                @lang('lang_v1.leave_empty_to_autogenerate')
			            </p>
					</div>
				</div>

				<!-- Payment Date -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('payment_date', __('lang_v1.payment_date') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							{!! Form::text('payment_date', @format_datetime($income->payment_date), ['class' => 'form-control paid_on', 'readonly', 'required']); !!}
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<!-- Row 3: Applicable Tax, Payment Method, Amount -->
				<!-- Applicable Tax -->
				<div class="col-sm-4">
			    	<div class="form-group">
			            {!! Form::label('tax_id', __('product.applicable_tax') . ':' ) !!}
			            <div class="input-group">
			                <span class="input-group-addon">
			                    <i class="fa fa-info"></i>
			                </span>
			                {!! Form::select('tax_id', $taxes['tax_rates'], $income->tax_id, ['class' => 'form-control'], $taxes['attributes']); !!}
							<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" value="0">
			            </div>
			        </div>
			    </div>

			    <!-- Payment Method -->
			    <div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('payment_method', __('lang_v1.payment_method') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fas fa-money-bill-alt"></i>
							</span>
							{!! Form::select('payment_method', $payment_types, $income->payment_method, ['class' => 'form-control select2', 'required']); !!}
						</div>
					</div>
				</div>

				<!-- Amount -->
			    <div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('final_total', __('sale.total_amount') . ':*') !!}
						{!! Form::text('final_total', @num_format($income->final_total), ['class' => 'form-control input_number', 'placeholder' => __('sale.total_amount'), 'required', 'id' => 'final_total']); !!}
					</div>
				</div>

				<div class="clearfix"></div>

				<!-- Row 4: Document Attach -->
				<div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                        {!! Form::file('document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                        <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                        @includeIf('components.document_help_text')</p></small>
                        @if($income->document)
                            <p class="help-block">
                                <a href="{{ url('uploads/documents/' . $income->document) }}" download>
                                    <i class="fa fa-download"></i> @lang('purchase.download_document')
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

				<div class="clearfix"></div>

				<!-- Narration -->
				<div class="col-sm-12">
					<div class="form-group">
						{!! Form::label('additional_notes', __('income.narration') . ':') !!}
						{!! Form::textarea('additional_notes', $income->additional_notes, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('income.narration')]); !!}
					</div>
				</div>
			</div>
		</div>
	</div> <!--box end-->

	<div class="col-sm-12 text-center">
		<button type="submit" class="btn btn-primary btn-big">@lang('messages.update')</button>
	</div>
{!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready( function(){
		$('.paid_on').datetimepicker({
            format: moment_date_format + ' ' + moment_time_format,
            ignoreReadonly: true,
        });
	});
	
	__page_leave_confirmation('#add_income_form');
</script>
@endsection
