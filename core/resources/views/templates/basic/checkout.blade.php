@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="cart-section py-60 bg-white">
        <div class="checkout-section pt-60 pb-60 bg-white">
            <div class="container">
                <form id="checkout-form" action="{{ route('user.checkout.order') }}" method="POST">
                    @csrf
                    <div class="row gy-4 gy-sm-5">
                        <div class="col-lg-7">
                            <div class="checkout-wrapper order-summary">
                                <h6 class="mb-4">@lang('Billing details')</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('First name')</label>
                                            <input type="text" class="form-control form--control" name="firstname" required value="{{ $user->firstname }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Last name')</label>
                                            <input type="text" class="form-control form--control" name="lastname" required value="{{ $user->lastname }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Phone')</label>
                                            <input type="tel" class="form-control form--control" name="mobile" required value="{{ $user->mobile }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Email address')</label>
                                            <input type="email" name="email" class="form-control form--control" required value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Country')</label>
                                            <input type="text" class="form-control form--control" name="country_name" required value="{{ old('country_name', $user->country_name) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Shipping Area')</label>
                                            <select name="shipping_method" class="form-select form--control select2-basic" required>
                                                <option selected disabled>@lang('Select One')</option>
                                                @foreach ($shippingMethod as $method)
                                                    <option value="{{ $method->id }}" data-price="{{$method->price}}">{{ __($method->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Address')</label>
                                            <input type="text" class="form-control form--control" name="address" required value="{{ old('address', $user->address) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('State')</label>
                                            <input type="text" class="form-control form--control" name="state" required value="{{ old('state', $user->state) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('City')</label>
                                            <input type="text" class="form-control form--control" name="city" required value="{{ old('city', $user->city) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Zip')</label>
                                            <input type="text" class="form-control form--control" name="zip" required value="{{ old('zip', $user->zip) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="order-summary">
                                <h6 class="border-bottom pb-2">@lang('Order detail')</h6>
                                <ul class="subtotal-area">
                                    <li class="border-bottom my-3">
                                        <h6 class="title">@lang('Subtotal')</h6>
                                        <b class="text--base fs--14px"><span>{{ gs('cur_sym') }}{{ getAmount($data['subtotal']) }}</span></b>
                                    </li>

                                    <li class="border-bottom my-3">
                                        <h6 class="title">@lang('Total')</h6>
                                        <b class="text--base fs--14px"><span>{{ gs('cur_sym') }}{{ getAmount($data['total']) }}</span></b>
                                    </li>
                                </ul>
                                <ul class="subtotal-area mt-3 grand-total d-none">
                                    <li class="border-bottom my-3">
                                        <h6 class="title">@lang('Shipping Charge')</h6>
                                        <b class="shipping-price text--base">
                                            <span>{{ gs('cur_sym') }}0.00</span>
                                        </b>
                                    </li>
                                    <li class="border-bottom my-3">
                                        <h6 class="title">@lang('Grand Total')</h6>
                                        <b class="grand-total-price text--base">
                                            <span>{{ gs('cur_sym') }}{{ $data['total'] }}</span>
                                        </b>
                                    </li>
                                </ul>

                                <div class="payment-methods mt-4">
                                    <h6 class="border-bottom pb-2">@lang('Payment methods')

                                    </h6>
                                    <div class="payment-methods d-flex flex-wrap mt-3" style="gap:10px">
                                        <div class="d-flex flex-wrap" style="gap:25px">
                                            <div class="form-check form--check">
                                                <input id="onlinePayment" type="radio" class="form-check-input" name="payment_type" value="1">
                                                <label for="onlinePayment" class="form-check-label">@lang('Online Payment')</label>
                                            </div>
                                            <div class="form-check form--check">
                                                <input id="offlinePayment" type="radio" class="form-check-input" name="payment_type" value="2">
                                                <label for="offlinePayment" class="form-check-label">@lang('Cash On Delivery')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline--primary w-100 btn-sm mt-4" form="checkout-form">@lang('Place order')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use script';
            $(document).ready(function() {
                $('.select2-basic').select2();
            })
            $('[name=shipping_method]').on('change', function() {
                let subtotal = parseFloat('{{getAmount($data['subtotal'])}}');
                let price = parseFloat($(this).find(":selected").data('price'));
                let grandTotal = (subtotal + price);

                $('.grand-total').removeClass('d-none');
                $('.shipping-price').text("{{ gs('cur_sym') }}" + price);
                $('.grand-total-price').text("{{ gs('cur_sym') }}" + parseFloat(grandTotal).toFixed(2));
            });
        })(jQuery);
    </script>
@endpush
