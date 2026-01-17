<div class="col-xs-12">
    @component('components.widget')
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width: 70%;">@lang('report.profit_loss')</th>
                    <th style="width: 30%; text-align: right;">@lang('sale.total_amount')</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>@lang('lang_v1.revenue')</strong></td>
                    <td style="text-align: right;">
                        <span class="display_currency" data-currency_symbol="true">{{$data['revenue']}}</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>@lang('lang_v1.cost_of_sale')</strong></td>
                    <td style="text-align: right;">
                        <span class="display_currency" data-currency_symbol="true">{{$data['cost_of_sale']}}</span>
                    </td>
                </tr>
                <tr style="background-color: #f5f5f5;">
                    <td><strong>@lang('lang_v1.gross_profit')</strong></td>
                    <td style="text-align: right;">
                        <strong><span class="display_currency" data-currency_symbol="true">{{$data['gross_profit_simplified']}}</span></strong>
                    </td>
                </tr>
                <tr>
                    <td><strong>@lang('income.income')</strong></td>
                    <td style="text-align: right;">
                        <span class="display_currency" data-currency_symbol="true">{{$data['total_income']}}</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>@lang('lang_v1.admin_expenses')</strong></td>
                    <td style="text-align: right;">
                        <span class="display_currency" data-currency_symbol="true">{{$data['admin_expenses']}}</span>
                    </td>
                </tr>
                <tr style="background-color: #e8f5e9; border-top: 2px solid #4caf50;">
                    <td><strong>@lang('report.net_profit')</strong></td>
                    <td style="text-align: right;">
                        <strong><span class="display_currency" data-currency_symbol="true">{{$data['net_profit']}}</span></strong>
                    </td>
                </tr>
            </tbody>
        </table>
    @endcomponent
</div>
