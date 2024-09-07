@extends($activeTemplate . "layouts.master")
@section("content")
        <div class="notice"></div>
        <!-- Dashboard Card Start -->
        <div class="row gy-4 justify-content-center dashboard-widget-wrapper">
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-list-ul"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-list-ul"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Total Order </span>
                        <h2 class="dashboard-widget__number"> 48 </h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-spinner"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-spinner"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Order Pending</span>
                        <h2 class="dashboard-widget__number">65</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-clipboard-check"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-clipboard-check"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Order confirm </span>
                        <h2 class="dashboard-widget__number"> 45 </h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-pause-circle"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-pause-circle"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Processing Orders </span>
                        <h2 class="dashboard-widget__number"> 1 </h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-shopping-basket"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-shopping-basket"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Dispatched Orders </span>
                        <h2 class="dashboard-widget__number"> 0 </h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon flex-center">
                        <i class="las la-ban"></i>
                    </div>
                    <span class="dashboard-widget__shape">
                        <i class="las la-ban"></i>
                    </span>
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text"> Order Cancel </span>
                        <h2 class="dashboard-widget__number"> 48 </h2>
                    </div>
                </div>
            </div>

        </div>
        <!-- Dashboard Card End -->
        <div class="dashboard-table">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-header__title"> {{ __($pageTitle) }} </h5>
                </div>
                <div class="card-body">
                    <table class="cmn--table table">
                        <thead>
                            <tr>
                                <th>@lang("Order No")</th>
                                <th>@lang("Payment Type")</th>
                                <th>@lang("Amount")</th>
                                <th>@lang("Status")</th>
                                <th>@lang("Time")</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_no }}</td>
                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_ONLINE)
                                            @lang("Online Payment")
                                        @else
                                            @lang("Cash On Delivery")
                                        @endif
                                    </td>
                                    <td class="text--base">
                                        <strong>{{ showAmount($order->total) }}</strong>
                                    </td>
                                    <td> @php echo $order->ordersBadge; @endphp
                                    </td>
                                    <td>
                                        {{ showDateTime($order->created_at) }}
                                        <br>{{ diffForHumans($order->created_at) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection

{{-- <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">{{ __($pageTitle) }}</h5>
                </div>
                <div class="card-body">
                    <table class="cmn--table table">
                        <thead>
                            <tr>
                                <th>@lang("Order No")</th>
                                <th>@lang("Payment Type")</th>
                                <th>@lang("Amount")</th>
                                <th>@lang("Status")</th>
                                <th>@lang("Time")</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_no }}</td>
                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_ONLINE)
                                        @lang("Online Payment")
                                        @else
                                        @lang("Cash On Delivery")
                                        @endif
                                    </td>
                                    <td class="text--base">
                                        <strong>{{ showAmount($order->total) }}</strong>
                                    </td>
                                    <td> @php echo $order->ordersBadge; @endphp
                                    </td>
                                    <td>
                                        {{ showDateTime($order->created_at) }}
                                        <br>{{ diffForHumans($order->created_at) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-10 userWidget d-flex justify-content-between mt-4">
            <div class="card" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total Order")</div>
                    <h2 class="card-title">{{ $singleOrder["total"] }}</h2>
                </div>
            </div>
            <div class="card" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total Pending Order") </div>
                    <h2 class="card-title">{{ $singleOrder["pending"] ?? "N/A" }}</h2>
                </div>
            </div>
            <div class="card" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total Confirmed Order")</div>
                    <h2 class="card-title">{{ $singleOrder["confirmed"] ?? "N/A" }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-10 userWidget d-flex justify-content-between mt-4">

            <div class="card m-0 p-2" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total Shipped Order")</div>
                    <h2 class="card-title">{{ $singleOrder["shipped"] ?? "N/A" }}</h2>
                </div>
            </div>

            <div class="card m-0 p-2" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total delivered Order")</div>
                    <h2 class="card-title">{{ $singleOrder["delivered"] ?? "N/A" }}</h2>
                </div>
            </div>

            <div class="card m-0 p-2" style="width: 25rem">
                <div class="card-body">
                    <div class="lead">@lang("Total Cancelled Order")</div>
                    <h2 class="card-title">{{ $singleOrder["cancelled"] ?? "N/A" }}</h2>
                </div>
            </div>

        </div>
    </div> --}}
