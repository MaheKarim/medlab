@extends('admin.layouts.app')

@section('panel')

    <div class="row gy-4">

        <div class="col-xxl-3 col-sm-6">

            <x-widget
                style="6"
                link="{{route('admin.users.all')}}"
                icon="las la-users"
                title="Total Users"
                value="{{$widget['total_users']}}"
                bg="primary"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.users.active')}}"
                icon="las la-user-check"
                title="Active Users"
                value="{{$widget['verified_users']}}"
                bg="success"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.users.email.unverified')}}"
                icon="lar la-envelope"
                title="Email Unverified Users"
                value="{{$widget['email_unverified_users']}}"
                bg="danger"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.users.mobile.unverified')}}"
                icon="las la-comment-slash"
                title="Mobile Unverified Users"
                value="{{$widget['mobile_unverified_users']}}"
                bg="warning"
            />
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->
    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="2"
                icon_style="false"
                link="{{ route('admin.order.delivered') }}"
                title="{{ __('Delivered Orders') }}"
                icon="las la-check-circle"
                value="{{ $order['delivered_order'] }}"
                color="success"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="2"
                icon_style="false"
                link="{{ route('admin.order.cancel') }}"
                title="{{ __('Canceled Orders') }}"
                icon="las la-times-circle"
                value="{{ $order['canceled_order'] }}"
                color="danger"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="2"
                icon_style="false"
                link="{{ route('admin.product.index') }}"
                title="{{ __('Total Product') }}"
                icon="fab fa-product-hunt"
                value="{{ $widget['total_product'] }}"
                color="success"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="2"
                icon_style="false"
                link="{{ route('admin.category.index') }}"
                title="{{ __('Total Category') }}"
                icon="las la-stream"
                value="{{ $widget['total_category'] }}"
                color="primary"
            />
        </div>
    </div><!-- row end-->

    <div class="row mt-2 gy-4">
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title">@lang('Payments')</h5>
                    <div class="widget-card-wrapper">

                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_amount']) }}</h6>
                                    <p class="widget-card-title">@lang('Total Payments')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.deposit.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_pending'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Payments')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--danger">
                            <a href="{{ route('admin.deposit.rejected') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_rejected'] }}</h6>
                                    <p class="widget-card-title">@lang('Rejected Payments')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_charge']) }}</h6>
                                    <p class="widget-card-title">@lang('Payments Charge')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card box-shadow3 h-100">
                <div class="card-body">
                    <h5 class="card-title">@lang('Orders')</h5>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.order.index') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="lar la-credit-card"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $order['total_order'] }}</h6>
                                    <p class="widget-card-title">@lang('Total Orders')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.order.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $order['pending_order'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Orders')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.order.confirmed') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-columns"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $order['confirmed_order'] }}</h6>
                                    <p class="widget-card-title">@lang('Confirmed Orders')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.order.shipped') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-percent"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $order['shipped_order'] }}</h6>
                                    <p class="widget-card-title">@lang('Shipped Orders')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h5 class="card-title">@lang('Sales Report')</h5>

                    <div id="dwDatePicker" class="border p-1 cursor-pointer rounded">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span> <i class="la la-caret-down"></i>
                    </div>
                </div>
                <div id="dwChartArea"> </div>
              </div>
            </div>
          </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <h5 class="card-title">@lang('Transactions Report')</h5>

                    <div id="trxDatePicker" class="border p-1 cursor-pointer rounded">
                        <i class="la la-calendar"></i>&nbsp;
                        <span></span> <i class="la la-caret-down"></i>
                    </div>
                </div>

                <div id="transactionChartArea"></div>
              </div>
            </div>
        </div>
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Order History')</h5>

                        <div id="orderDatePicker" class="border p-1 cursor-pointer rounded">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>

                    <div id="orderChartArea"></div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mt-30">@lang('Best Selling Products')</h5>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Sale Count')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Created At')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bestSellingItems as $product)
                                <tr>
                                    <td>
                                        <div class="user">
                                            <div class="thumb">
                                                <img src="{{ getImage(getFilePath('product') . '/' . $product->image) }}" alt="@lang('image')">
                                            </div>
                                            <span class="name">{{ __($product->name) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->discount > 0)
                                            <del>{{ showAmount($product->price) }}</del> <br>
                                            @php
                                                if ($product->discount_type == Status::FLAT_DISCOUNT) {
                                                    $discountedPrice = $product->price - $product->discount;
                                                } elseif ($product->discount_type == Status::PERCENT_DISCOUNT) {
                                                    $discountedPrice = $product->price - ($product->price * $product->discount / 100);
                                                }
                                            @endphp
                                            <b> {{ showAmount($discountedPrice) }} </b>
                                        @else
                                            {{ showAmount($product->price) }}
                                        @endif
                                    </td>
                                    <td>
                                        @php  echo $product->quantityBadge; @endphp
                                    </td>
                                    <td>
                                        {{ __($product->sale_count) }}
                                    </td>
                                    <td>
                                        @php
                                            echo $product->statusBadge;
                                        @endphp
                                    </td>
                                    <td>
                                        {{ showDateTime($product->created_at) }}
                                        <br>
                                        {{ diffForHumans($product->created_at) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let dwChart = barChart(
            document.querySelector("#dwChartArea"),
            @json(__(gs('cur_text'))),
            [{
                name: 'Deposited',
                data: []
            },
                {
                    name: 'Withdrawn',
                    data: []
                }
            ],
            [],
        );

        let trxChart = lineChart(
            document.querySelector("#transactionChartArea"),
            [{
                name: "Plus Transactions",
                data: []
            },
                {
                    name: "Minus Transactions",
                    data: []
                }
            ],
            []
        );


        let orderChartData = lineChart(
            document.querySelector("#orderChartArea"),
            [{
                name: "Pending Order",
                data: [],
                backgroundColor: "black"
            },
                {
                    name: "Confirm Order",
                    data: []
                },
                {
                    name: "Shipped Order",
                    data: []
                },
                {
                    name: "Delivered Order",
                    data: []
                },
                {
                    name: "Cancel Order",
                    data: []
                }
            ],
            []
        );


        const depositChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = @json(route('admin.chart.deposit'));
            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        dwChart.updateSeries(data.data);
                        dwChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        const transactionChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = @json(route('admin.chart.transaction'));


            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }


        const orderChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = @json(route('admin.chart.order'));

            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        orderChartData.updateSeries(data.data);
                        orderChartData.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            },
                            colors: [
                                'rgba(255, 99, 132, 1)', // Red
                                'rgba(54, 162, 235, 1)', // Blue
                                'rgba(255, 206, 86, 1)', // Yellow
                                'rgba(75, 192, 192, 1)', // Teal
                                'rgba(153, 102, 255, 1)', // Purple
                                'rgba(255, 159, 64, 1)' // Orange
                            ]
                        });
                    }
                }
            );
        }

        $('#dwDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#dwDatePicker span',
            start, end));
        $('#trxDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#trxDatePicker span',
            start, end));
        $('#orderDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText(
            '#orderDatePicker span',
            start, end));

        changeDatePickerText('#dwDatePicker span', start, end);
        changeDatePickerText('#trxDatePicker span', start, end);
        changeDatePickerText('#orderDatePicker span', start, end);

        depositChart(start, end);
        transactionChart(start, end);
        orderChart(start, end);

        $('#dwDatePicker').on('apply.daterangepicker', (event, picker) => depositChart(picker.startDate, picker
            .endDate));

        $('#trxDatePicker').on('apply.daterangepicker', (event, picker) => transactionChart(picker.startDate, picker
            .endDate));

        $('#orderDatePicker').on('apply.daterangepicker', (event, picker) => orderChart(picker.startDate, picker
            .endDate));

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chart['user_browser_counter']->keys()),
            @json(@$chart['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chart['user_os_counter']->keys()),
            @json(@$chart['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chart['user_country_counter']->keys()),
            @json(@$chart['user_country_counter']->flatten())
        );
    </script>
@endpush
@push('style')
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }
    </style>
@endpush
