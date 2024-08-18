@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.deposit.list', $user->id) }}"
                        title="Payments"
                        icon="las la-money-bill-wave-alt"
                        value="{{ showAmount($totalDeposit) }}"
                        bg="18"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.index', ['search' => $user->username]) }}"
                        title="Total Order"
                        icon="las la-shopping-cart"
                        value="{{ $order['total'] }}"
                        bg="8"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.report.transaction', $user->id) }}"
                        title="Transactions"
                        icon="las la-exchange-alt"
                        value="{{ $totalTransaction }}"
                        bg="17"
                        type="2"
                    />
                </div>
            </div>

            <div class="row gy-4 mt-1">
                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.pending') }}?search={{ $user->username }}"
                        title="Pending Order"
                        icon="las la-spinner"
                        value="{{ $order['pending'] }}"
                        bg="warning"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.confirmed') }}?search={{ $user->username }}"
                        title="Confirmed Order"
                        icon="las la-check-double"
                        value="{{ $order['confirmed'] }}"
                        bg="success"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.shipped') }}?search={{ $user->username }}"
                        title="Shipped Order"
                        icon="las la-truck"
                        value="{{ $order['shipped'] }}"
                        bg="19"
                        type="2"
                    />
                </div>
            </div>

            <div class="row gy-4 mt-1">
                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.delivered') }}?search={{ $user->username }}"
                        title="Delivered Order"
                        icon="las la-check-circle"
                        value="{{ $order['delivered'] }}"
                        bg="info"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.cancel') }}?search={{ $user->username }}"
                        title="Rejected Order"
                        icon="las la-times-circle"
                        value="{{ $order['canceled'] }}"
                        bg="danger"
                        type="2"
                    />
                </div>

                <div class="col-xxl-4 col-sm-6">
                    <x-widget
                        style="6"
                        link="{{ route('admin.order.shipped') }}?search={{ $user->username }}"
                        title="Support Ticket"
                        icon="las la-ticket-alt"
                        value="{{ $order['ticket'] }}"
                        bg="11"
                        type="2"
                    />
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">

                <div class="flex-fill">
                    <a href="{{route('admin.report.login.history')}}?search={{ $user->username }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.users.notification.log',$user->id) }}" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>


                <div class="flex-fill">
                    @if($user->status == Status::USER_ACTIVE)
                    <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-ban"></i>@lang('Ban User')
                    </button>
                    @else
                    <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-undo"></i>@lang('Unban User')
                    </button>
                    @endif
                </div>
            </div>

            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{$user->fullname}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{$user->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{$user->lastname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $user->mobile }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{@$user->address}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{@$user->city}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{@$user->state}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{@$user->zip}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}" @selected($user->country_code == $key)>{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Email Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                           data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                           @if($user->ev) checked @endif>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Mobile Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                           data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                           @if($user->sv) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn btn-sm btn-outline--primary" ><i class="las la-sign-in-alt"></i>@lang('Login as User')</a>
@endpush

@push('script')
<script>
    (function($){
    "use strict"
        let mobileElement = $('.mobile-code');
        $('select[name=country]').on('change',function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });
    })(jQuery);
</script>
@endpush
