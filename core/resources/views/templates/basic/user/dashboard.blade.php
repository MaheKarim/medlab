@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="notice"></div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table cmn--table">
                            <thead>
                            <tr>
                                <th>@lang('Order No')</th>
                                <th>@lang('Payment Type')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_no }}</td>
                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_ONLINE)
                                            @lang('Online Payment')
                                        @else
                                            @lang('Cash On Delivery')
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
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-10 userWidget mt-4 d-flex justify-content-between">
                <div class="card" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total Order')</div>
                        <h2 class="card-title">{{ $singleOrder['total'] }}</h2>
                    </div>
                </div>
                <div class="card" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total Pending Order') </div>
                        <h2 class="card-title">{{ $singleOrder['pending'] ?? 'N/A' }}</h2>
                    </div>
                </div>
                <div class="card" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total Confirmed Order')</div>
                        <h2 class="card-title">{{ $singleOrder['confirmed'] ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-10 userWidget mt-4 d-flex justify-content-between">

                <div class="card p-2 m-0" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total Shipped Order')</div>
                        <h2 class="card-title">{{ $singleOrder['shipped'] ?? 'N/A' }}</h2>
                    </div>
                </div>

                <div class="card p-2 m-0" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total delivered Order')</div>
                        <h2 class="card-title">{{ $singleOrder['delivered'] ?? 'N/A' }}</h2>
                    </div>
                </div>

                <div class="card p-2 m-0" style="width: 25rem">
                    <div class="card-body">
                        <div class="lead">@lang('Total Cancelled Order')</div>
                        <h2 class="card-title">{{ $singleOrder['cancelled'] ?? 'N/A' }}</h2>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
