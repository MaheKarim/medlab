@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table--responsive--lg">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Order ID')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Payment Type')</th>
                                <th scope="col">@lang('Payment Status')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Order Time')</th>
                                <th scope="col">@lang('Details')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_no }}</td>
                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_ONLINE)
                                            @lang('Online Payment')
                                        @else
                                            @lang('Cash On Delivery')
                                        @endif
                                    </td>
                                    <td>{{ showAmount($order->total) }}</td>
                                    <td>
                                        @php
                                            echo $order->paymentBadge;
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            echo $order->ordersBadge;
                                        @endphp

                                        @if (@$order->deposit->admin_feedback != null)
                                            <span class="badge badge--info status-info detailBtn" data-admin_feedback="{{ __(@$order->deposit->admin_feedback) }}"><i class="fa fa-info"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ showDateTime($order->created_at) }}
                                        <br>{{ diffForHumans($order->created_at) }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user.order.details', $order->id) }}"
                                           class="btn btn--sm btn--primary">@lang('Details')</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                {{ paginateLinks($orders) }}
                </div>
            </div>
        </div>
    </div>
@endsection
