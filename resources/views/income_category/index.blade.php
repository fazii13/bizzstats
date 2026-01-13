@extends('layouts.app')
@section('title', __('income.income_categories'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'income.income_categories' )
        <small>@lang( 'income.manage_your_income_categories' )</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'income.all_your_income_categories' )])
        @slot('tool')
            <div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                data-href="{{action([\App\Http\Controllers\IncomeCategoryController::class, 'create'])}}" 
                data-container=".income_category_modal">
                <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
            </div>
        @endslot
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="income_category_table">
                <thead>
                    <tr>
                        <th>@lang( 'income.category_name' )</th>
                        <th>@lang( 'income.category_code' )</th>
                        <th>@lang( 'messages.action' )</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    <div class="modal fade income_category_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        var income_category_table = $('#income_category_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{action([\App\Http\Controllers\IncomeCategoryController::class, "index"])}}',
            columns: [
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'code', name: 'code', orderable: true, searchable: true },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']]
        });

        $(document).on('submit', 'form#income_category_add_form', function(e){
            e.preventDefault();
            $(this).find('button[type="submit"]').attr('disabled', true);
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).find('input[name="_method"]').val() || 'POST';

            $.ajax({
                method: method,
                url: url,
                dataType: 'json',
                data: data,
                success: function(result){
                    if(result.success == true){
                        $('div.income_category_modal').modal('hide');
                        toastr.success(result.msg);
                        income_category_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                    $('form#income_category_add_form').find('button[type="submit"]').attr('disabled', false);
                },
                error: function(xhr){
                    $('form#income_category_add_form').find('button[type="submit"]').attr('disabled', false);
                    toastr.error(__translate('messages.something_went_wrong'));
                }
            });
        });

        $(document).on('click', 'button.delete_income_category', function(){
            var url = $(this).data('href');
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        dataType: 'json',
                        success: function(result){
                            if(result.success == true){
                                toastr.success(result.msg);
                                income_category_table.ajax.reload();
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
