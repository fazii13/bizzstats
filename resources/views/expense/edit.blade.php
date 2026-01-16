@extends('layouts.app')
@section('title', __('expense.edit_expense'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('expense.edit_expense')</h1>
</section>

<!-- Main content -->
<section class="content">
  {!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'update'], [$expense->id]), 'method' => 'PUT', 'id' => 'add_expense_form', 'files' => true ]) !!}
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('expense_category_id', __('expense.expense_category').':') !!}
            {!! Form::select('expense_category_id', $expense_categories, $expense->expense_category_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('expense_sub_category_id', __('product.sub_category')  . ':') !!}
                  {!! Form::select('expense_sub_category_id', $sub_categories, $expense->expense_sub_category_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
            </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('work_order_number', __('lang_v1.work_order_number').':') !!}
            {!! Form::text('work_order_number', $expense->work_order_number, ['class' => 'form-control', 'placeholder' => __('lang_v1.work_order_number')]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('ref_no', __('purchase.ref_no').':*') !!}
            {!! Form::text('ref_no', $expense->ref_no, ['class' => 'form-control', 'required']); !!}
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
              {!! Form::text('transaction_date', @format_datetime($expense->transaction_date), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('expense_for', __('expense.expense_for').':') !!} @show_tooltip(__('tooltip.expense_for'))
            {!! Form::select('expense_for', $users, $expense->expense_for, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('contact_id', __('lang_v1.expense_for_contact').':') !!} 
            {!! Form::select('contact_id', $contacts, $expense->contact_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                {!! Form::file('document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                <p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                @includeIf('components.document_help_text')</p>
            </div>
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
  <div class="col-sm-12 text-center">
    <button type="submit" class="btn btn-primary btn-big">@lang('messages.update')</button>
  </div>

{!! Form::close() !!}
</section>
@stop
@section('javascript')
<script type="text/javascript">
  __page_leave_confirmation('#add_expense_form');
  
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
    
    // Format existing expense_details for JavaScript
    $existing_details = [];
    if ($expense->expense_details && $expense->expense_details->count() > 0) {
      $decimal_separator = session('currency')['decimal_separator'] ?? '.';
      $thousand_separator = session('currency')['thousand_separator'] ?? ',';
      $precision = session('business.currency_precision', 2);
      
      foreach ($expense->expense_details as $detail) {
        $existing_details[] = [
          'location_id' => $detail->location_id,
          'tax_id' => $detail->tax_id,
          'amount' => $detail->amount,
          'amount_formatted' => number_format((float)$detail->amount, $precision, $decimal_separator, $thousand_separator),
          'note' => $detail->note
        ];
      }
    }
  @endphp
  
  var business_locations = @json($locations_array);
  var tax_rates = @json($taxes['tax_rates'] ?? []);
  var tax_attributes = @json($taxes['attributes'] ?? null);
  var expense_detail_row_index = 0;
  var existing_expense_details = @json($existing_details);
  
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
  
  function addExpenseDetailRow(expense_detail_data) {
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
    
    // Populate data if provided
    if (expense_detail_data) {
      new_row.find('.expense_detail_location').val(expense_detail_data.location_id).trigger('change');
      new_row.find('.expense_detail_tax').val(expense_detail_data.tax_id || '').trigger('change');
      new_row.find('.expense_detail_amount').val(expense_detail_data.amount_formatted || expense_detail_data.amount);
      new_row.find('.expense_detail_note').val(expense_detail_data.note || '');
    }
    
    // Update total when amount changes in the new row
    new_row.find('.expense_detail_amount').on('change keyup', function() {
      calculateExpensePaymentDue();
    });
    
    expense_detail_row_index++;
  }
  
    // Load existing expense details on page load
    $(document).ready(function() {
      if (existing_expense_details && existing_expense_details.length > 0) {
        existing_expense_details.forEach(function(detail) {
          addExpenseDetailRow(detail);
        });
        // Recalculate total after loading all rows
        setTimeout(function() {
          calculateExpensePaymentDue();
        }, 500);
      }
    });
  
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
  
  // Calculate total from expense detail table rows
  function calculateTotalFromTable() {
    var total = 0;
    $('#expense_details_table tbody tr.expense_detail_row').each(function() {
      var amount = __read_number($(this).find('.expense_detail_amount'));
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
    // Update payment due if payment section exists
    if ($('#payment_due').length) {
      var payment_total = 0;
      $('.payment-amount').each(function() {
        var amount = __read_number($(this));
        if (!isNaN(amount)) {
          payment_total += amount;
        }
      });
      var due = final_total - payment_total;
      $('#payment_due').text(__currency_trans_from_en(due, true, false));
    }
  }
  
  // Recalculate when expense amounts or payment amounts change
  $(document).on('change keyup', '.expense_detail_amount, input.payment-amount', function() {
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