@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="notice"></div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Price</th>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Order Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th>{{ $order->order_no }}</th>
                                    <td>{{ showAmount($order->total) }}</td>
                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_ONLINE)
                                            @lang('Online Payment')
                                        @else
                                            @lang('Cash On Delivery')
                                        @endif
                                    </td>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="modal fade" id="kycRejectionReason">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <p>MK</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
