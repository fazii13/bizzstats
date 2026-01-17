@extends('layouts.app')
@section('title', __('income.income'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('income.income')</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
                @if(auth()->user()->can('all_income.access'))
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('location_id',  __('purchase.business_location') . ':') !!}
                            {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('income_date_range', __('report.date_range') . ':') !!}
                        {!! Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'income_date_range', 'readonly']); !!}
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('income.all_income')])
                @can('income.add')
                    @slot('tool')
                        <div class="box-tools">
                            <a class="btn btn-block btn-primary" href="{{action([\App\Http\Controllers\IncomeController::class, 'create'])}}">
                            <i class="fa fa-plus"></i> @lang('messages.add')</a>
                        </div>
                    @endslot
                @endcan
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="income_table">
                        <thead>
                            <tr>
                                <th>@lang('messages.action')</th>
                                <th>@lang('messages.date')</th>
                                <th>@lang('purchase.ref_no')</th>
                                <th>@lang('income.income_category')</th>
                                <th>@lang('business.location')</th>
                                <th>@lang('product.tax')</th>
                                <th>@lang('sale.total_amount')</th>
                                <th>@lang('lang_v1.payment_method')</th>
                                <th>@lang('income.narration')</th>
                                <th>@lang('lang_v1.added_by')</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-gray font-17 text-center footer-total">
                                <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                                <td class="footer_income_total"></td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        //Income table
        income_table = $('#income_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[1, 'desc']],
            scrollY: "75vh",
            scrollX: true,
            scrollCollapse: true,
            ajax: {
                url: "{{action([\App\Http\Controllers\IncomeController::class, 'index'])}}",
                data: function ( d ) {
                    if ($('#income_date_range').length && $('#income_date_range').data('daterangepicker')) {
                        d.start_date = $('#income_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        d.end_date = $('#income_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    }
                    if ($('#location_id').length && $('#location_id').val()) {
                        d.location_id = $('#location_id').val();
                    }
                    d = __datatable_ajax_callback(d);
                },
                error: function(xhr, error, thrown) {
                    console.log('DataTable Error:', error, thrown);
                    console.log('Response:', xhr.responseText);
                }
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'transaction_date', name: 'incomes.payment_date' },
                { data: 'ref_no', name: 'incomes.ref_no' },
                { data: 'category', orderable: false, searchable: false },
                { data: 'location_name', name: 'bl.name' },
                { data: 'tax', orderable: false, searchable: false },
                { data: 'final_total', name: 'incomes.final_total' },
                { data: 'payment_method', name: 'incomes.payment_method' },
                { data: 'additional_notes', name: 'incomes.additional_notes' },
                { data: 'added_by', orderable: false, searchable: false }
            ],
            fnDrawCallback: function(row, data, start, end, display) {
                __currency_convert_recursively($('#income_table'));
                var total_income = sum_table_col($('#income_table'), 'final-total');
                $('.footer_income_total').html(__currency_trans_from_en(total_income));
            },
        });

        //Date range as a button
        $('#income_date_range').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#income_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                income_table.ajax.reload();
            }
        );
        $('#income_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#income_date_range').val('');
            income_table.ajax.reload();
        });

        $(document).on('change', '#location_id', function() {
            income_table.ajax.reload();
        });

        $(document).on('click', 'a.delete_income', function(e) {
            e.preventDefault();
            var href = $(this).data('href');
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                income_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
