@extends('layouts.app')
@section('title', __('expense.add_expense'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('expense.add_expense')</h1>
</section>

<!-- Main content -->
<section class="content">
	{!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'store']), 'method' => 'post', 'id' => 'add_expense_form', 'files' => true ]) !!}
	<div class="box box-solid">
		<div class="box-body">
			<div class="row">

				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('expense_category_id', __('expense.expense_category').':') !!}
						{!! Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
			            {!! Form::label('expense_sub_category_id', __('product.sub_category') . ':') !!}
			              {!! Form::select('expense_sub_category_id', [],  null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
			          </div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('work_order_number', __('lang_v1.work_order_number').':') !!}
						{!! Form::text('work_order_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.work_order_number')]); !!}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('ref_no', __('purchase.ref_no').':') !!}
						{!! Form::text('ref_no', null, ['class' => 'form-control']); !!}
						<p class="help-block">
			                @lang('lang_v1.leave_empty_to_autogenerate')
			            </p>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('transaction_date', __('messages.date') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							{!! Form::text('transaction_date', @format_datetime('now'), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('expense_for', __('expense.expense_for').':') !!} @show_tooltip(__('tooltip.expense_for'))
						{!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('contact_id', __('lang_v1.expense_for_contact').':') !!} 
						{!! Form::select('contact_id', $contacts, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                        {!! Form::file('document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                        <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                        @includeIf('components.document_help_text')</p></small>
                    </div>
                </div>
				<div class="col-md-4 col-sm-6">
					<br>
					<label>
		              {!! Form::checkbox('is_refund', 1, false, ['class' => 'input-icheck', 'id' => 'is_refund']); !!} @lang('lang_v1.is_refund')?
		            </label>@show_tooltip(__('lang_v1.is_refund_help'))
				</div>
				<div class="clearfix"></div>
				<!-- Hidden select for cloning location options -->
				<select id="hidden_location_select" style="display:none;">
					@foreach($business_locations as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
				<div class="col-sm-12">
					<div class="form-group">
						<h4>Expense Details</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed" id="expense_details_table">
								<thead>
									<tr>
										<th>@lang('purchase.business_location')</th>
										<th>@lang('product.applicable_tax')</th>
										<th>@lang('sale.total_amount')</th>
										<th>@lang('expense.expense_note')</th>
										<th width="5%">@lang('messages.action')</th>
									</tr>
								</thead>
								<tbody>
									<!-- Rows will be added dynamically -->
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" style="text-align: right;">
											<strong>@lang('sale.total'):</strong>
										</td>
										<td>
											<strong id="expense_details_total">{{@num_format(0)}}</strong>
										</td>
										<td colspan="2">
											<button type="button" class="btn btn-primary btn-sm" id="add_expense_detail_row">
												<i class="fa fa-plus"></i> Add Row
											</button>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!--box end-->
	@include('expense.recur_expense_form_part')
	@component('components.widget', ['class' => 'box-solid', 'id' => "payment_rows_div", 'title' => __('purchase.add_payment')])
	<div class="payment_row">
		@include('sale_pos.partials.payment_row_form', ['row_index' => 0, 'show_date' => true])
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right">
					<strong>@lang('purchase.payment_due'):</strong>
					<span id="payment_due">{{@num_format(0)}}</span>
				</div>
			</div>
		</div>
	</div>
	@endcomponent
	<div class="col-sm-12 text-center">
		<button type="submit" class="btn btn-primary btn-big">@lang('messages.save')</button>
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
	
	__page_leave_confirmation('#add_expense_form');
	
	// Calculate total from expense detail table rows
	function calculateTotalFromTable() {
		var total = 0;
		$('.expense_detail_amount').each(function() {
			var amount = __read_number($(this));
			if (!isNaN(amount)) {
				total += amount;
			}
		});
		return total;
	}

	function updateExpenseDetailsTotal() {
		var total = calculateTotalFromTable();
		$('#expense_details_total').text(__currency_trans_from_en(total, true, false));
		return total;
	}

	function calculateExpensePaymentDue() {
		var final_total = updateExpenseDetailsTotal();
		var payment_amount = __read_number($('input.payment-amount'));
		var payment_due = final_total - payment_amount;
		$('#payment_due').text(__currency_trans_from_en(payment_due, true, false));
	}

	// Recalculate when expense amounts or payment amounts change
	$(document).on('change keyup', '.expense_detail_amount, input.payment-amount', function() {
		calculateExpensePaymentDue();
	});

	$(document).on('change', '#recur_interval_type', function() {
	    if ($(this).val() == 'months') {
	        $('.recur_repeat_on_div').removeClass('hide');
	    } else {
	        $('.recur_repeat_on_div').addClass('hide');
	    }
	});

	$('#is_refund').on('ifChecked', function(event){
		$('#recur_expense_div').addClass('hide');
	});
	$('#is_refund').on('ifUnchecked', function(event){
		$('#recur_expense_div').removeClass('hide');
	});

	$(document).on('change', '.payment_types_dropdown, #location_id', function(e) {
	    var default_accounts = $('select#location_id').length ? 
	                $('select#location_id')
	                .find(':selected')
	                .data('default_payment_accounts') : [];
	    var payment_types_dropdown = $('.payment_types_dropdown');
	    var payment_type = payment_types_dropdown.val();
	    if (payment_type) {
	        var default_account = default_accounts && default_accounts[payment_type]['account'] ? 
	            default_accounts[payment_type]['account'] : '';
	        var payment_row = payment_types_dropdown.closest('.payment_row');
	        var row_index = payment_row.find('.payment_row_index').val();

	        var account_dropdown = payment_row.find('select#account_' + row_index);
	        if (account_dropdown.length && default_accounts) {
	            account_dropdown.val(default_account);
	            account_dropdown.change();
	        }
	    }
	});

	// Expense Details Table - Add Row
	var expense_detail_row_index = 0;
	@php
		// Get locations as array with proper structure
		// Convert Collection to array while preserving key-value pairs
		if ($business_locations instanceof \Illuminate\Support\Collection) {
			$locations_array = [];
			foreach ($business_locations as $key => $value) {
				$locations_array[(string)$key] = $value;
			}
		} elseif (is_array($business_locations)) {
			$locations_array = [];
			foreach ($business_locations as $key => $value) {
				$locations_array[(string)$key] = $value;
			}
		} else {
			$locations_array = [];
		}
	@endphp
	var business_locations = @json($locations_array);
	var tax_rates = @json($taxes['tax_rates'] ?? []);
	var tax_attributes = @json($taxes['attributes'] ?? null);

	function escapeHtml(text) {
		var map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		};
		return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
	}

	function addExpenseDetailRow() {
		// Get location options from hidden select
		var location_options_html = '<option value="">@lang("messages.please_select")</option>';
		$('#hidden_location_select option').each(function() {
			var $option = $(this);
			location_options_html += '<option value="' + escapeHtml($option.val()) + '">' + escapeHtml($option.text()) + '</option>';
		});
		
		var row_html = '<tr class="expense_detail_row">' +
			'<td>' +
				'<select name="expense_details[' + expense_detail_row_index + '][location_id]" class="form-control select2 expense_detail_location" required>' +
					location_options_html +
				'</select>' +
			'</td>' +
			'<td>' +
				'<select name="expense_details[' + expense_detail_row_index + '][tax_id]" class="form-control select2 expense_detail_tax">' +
					'<option value="">@lang("messages.please_select")</option>';
		
		// Add tax options
		if (tax_rates) {
			$.each(tax_rates, function(key, value) {
				row_html += '<option value="' + escapeHtml(key) + '">' + escapeHtml(value) + '</option>';
			});
		}
		
		row_html += '</select>' +
			'</td>' +
			'<td>' +
				'<input type="text" name="expense_details[' + expense_detail_row_index + '][amount]" class="form-control input_number expense_detail_amount" placeholder="0.00" required>' +
			'</td>' +
			'<td>' +
				'<textarea name="expense_details[' + expense_detail_row_index + '][note]" class="form-control expense_detail_note" rows="2" placeholder="@lang("expense.expense_note")"></textarea>' +
			'</td>' +
			'<td>' +
				'<button type="button" class="btn btn-danger btn-sm remove_expense_detail_row">' +
					'<i class="fa fa-trash"></i>' +
				'</button>' +
			'</td>' +
		'</tr>';
		
		$('#expense_details_table tbody').append(row_html);
		
		// Initialize select2 for the new row
		var new_row = $('#expense_details_table tbody tr:last');
		new_row.find('.select2').select2();
		
		// Update total when amount changes in the new row
		new_row.find('.expense_detail_amount').on('change keyup', function() {
			calculateExpensePaymentDue();
		});
		
		expense_detail_row_index++;
	}

	// Add row button click
	$(document).on('click', '#add_expense_detail_row', function() {
		addExpenseDetailRow();
	});

	// Remove row button click
	$(document).on('click', '.remove_expense_detail_row', function() {
		$(this).closest('tr').remove();
		// Recalculate total after removing row
		calculateExpensePaymentDue();
	});

	// Validate form before submission - ensure at least one expense detail row exists
	$('#add_expense_form').on('submit', function(e) {
		var expense_detail_rows = $('#expense_details_table tbody tr.expense_detail_row').length;
		
		if (expense_detail_rows === 0) {
			e.preventDefault();
			toastr.error('Please add at least one expense detail row before submitting.');
			
			// Scroll to the expense details table
			$('html, body').animate({
				scrollTop: $('#expense_details_table').offset().top - 100
			}, 500);
			
			// Highlight the table section
			$('#expense_details_table').closest('.row').css({
				'background-color': '#fff3cd',
				'padding': '10px',
				'border-radius': '5px',
				'border': '2px solid #ffc107'
			});
			
			setTimeout(function() {
				$('#expense_details_table').closest('.row').css({
					'background-color': '',
					'padding': '',
					'border-radius': '',
					'border': ''
				});
			}, 3000);
			
			return false;
		}
	});
</script>
@endsection