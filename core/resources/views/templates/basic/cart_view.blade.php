@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="cart-section py-60 bg-white">
        <div class="container">
            <div class="cart-header">
                <h4 class="title mb-3">@lang('My Cart')</h4>
            </div>
            <table class="table cmn--table cart-table">
                <thead>
                <tr>
                    <th>@lang('Product')</th>
                    <th>@lang('Unit Price')</th>
                    <th>@lang('Quantity')</th>
                    <th>@lang('Subtotal')</th>
                    <th>@lang('Remove')</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($carts as $cart)
                    @php
                        $user     = auth()->user() ?? null;
                        $image    = $user ? @$cart->product->image : $cart->image;
                        $name     = $user ? @$cart->product->name : $cart->name;
                        $price    = $user ? productPrice($cart->product) : showDiscountPrice($cart->price, $cart->discount, $cart->discount_type);
                        $subTotal = $price * $cart->quantity;
                    @endphp
                    <tr>
                        <td>
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img
                                        src="{{ getImage(getFilePath('product') . '/' . $image, getFileSize('product')) }}"
                                        alt="products">
                                </div>
                                <div class="product-content">
                                    <h6 class="name">
                                        <a href="{{ route('product.details', [slug($name), $cart->product_id]) }}"
                                           class="productName"
                                           data-product_id="{{ $cart->product_id }}">{{ __($name) }}</a>
                                    </h6>
                                </div>
                            </div>
                        </td>

                        <td>
                                <span class="price">
                                    {{ showAmount($price, currencyFormat: false) }}
                                </span>
                        </td>
                        <td>
                            <div class="cart-plus-minus">
                                <div class="cart-decrease qtybutton dec">
                                    <i class="las la-minus"></i>
                                </div>
                                <input type="number" class="form-control" name="quantity" value="{{ $cart->quantity }}">
                                <div class="cart-increase qtybutton inc active">
                                    <i class="las la-plus"></i>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="subtotal">
                                {{ gs('cur_sym') }}{{ getAmount($subTotal) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn--danger remove-btn"><i class="las la-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%" class="text-center text--danger">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="row gy-4 pt-5 justify-content-between">
                <div class="col-md-5 col-xl-3">
                    <a href="{{ route('home') }}" class="btn btn-outline--primary  btn-lg fs-6 w-100">@lang('Continue Shopping ')
                        <i class="las la-long-arrow-alt-right ms-3"></i>
                    </a>
                </div>

                <div class="col-xl-4">
                    <ul class="cart-details">
                        <li>
                            <h6 class="title">@lang('Subtotal')</h6>
                            <h6 class="value subtotal-price text--base">{{ gs('cur_sym') }}0.00</h6>
                        </li>

                        <li class="total-show d-none">
                            <h6 class="title">@lang('Total')</h6>
                            <h6 class="value total total-price text--base">{{ gs('cur_sym') }}0.00</h6>
                        </li>
                        <li>
                            <a href="{{ route('user.checkout.index') }}" class="checkoutBtn btn btn-outline--primary w-100">@lang('Proceed to Checkout')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeCartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title">@lang('Confirmation Alert!')</strong>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this product?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn-primary remove-product">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            let removeableItem = null;
            let modal = $('#removeCartModal');

            let currentRow;
            let quantity

            $('.cart-decrease').click(function () {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                if (quantity > 0) {
                    CartCalculation(currentRow)
                } else {
                    currentRow.find('input[name="quantity"]').val(1)
                    notify('error', 'You have to order a minimum amount of one.');
                }
            });

            $('.cart-increase').click(function () {
                currentRow = $(this).closest("tr");
                CartCalculation(currentRow)
            });

            $('input[name="quantity"]').on('focusout', function () {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();

                if (parseInt(quantity) > 0) {
                    CartCalculation(currentRow)
                } else {
                    currentRow.find('input[name="quantity"]').val(1)
                    CartCalculation(currentRow)
                    notify('error', 'You have to order a minimum amount of one.');
                }
            });

            $('.remove-btn').on('click', function () {
                removeableItem = $(this).closest("tr");
                modal.modal('show');
            });

            $(".remove-product").on('click', function () {
                let product_id = removeableItem.find('.productName').data('product_id');
                $('.coupon-show').addClass('d-none');
                $('.total-show').addClass('d-none');
                $('.coupon').val('');
                $.ajax({
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('cart.remove') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            removeableItem.remove();
                            subTotal();
                            getCartCount();
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
                modal.modal('hide');
            });

            getCartCount();

            function getCartCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('cart.getCartTotal') }}",
                    success: function (response) {
                        $('.cart-count').text(response);
                    }
                });
            }

            subTotal();

            function subTotal() {

                var totalArr = [];
                var subtotal = 0;

                $('.cart-table tr').each(function (index, tr) {
                    $(tr).find('td').each(function (index, td) {
                        $(td).find('.subtotal').each(function (index, value) {
                            var productPrice = $(value).text();
                            var splitPrice = productPrice.split("{{ gs('cur_sym') }}");
                            var price = parseFloat(splitPrice[1]);
                            totalArr.push(price);
                        });
                    });
                });

                for (var i = 0; i < totalArr.length; i++) {
                    subtotal += totalArr[i];
                }

                $('.subtotal-price').text("{{ gs('cur_sym') }}" + subtotal.toFixed(2));
                $('.total-price').text("{{ gs('cur_sym') }}" + subtotal.toFixed(2));

                if (subtotal > 0) {
                    $('.checkoutBtn').removeClass('d-none');
                } else {
                    $('.checkoutBtn').addClass('d-none');
                }
            }

            function CartCalculation(currentRow) {

                let product_id = currentRow.find('.productName').data('product_id');
                let quantity = currentRow.find('input[name="quantity"]').val();
                let productPrice = currentRow.find('.price').text();
                let splitPrice = productPrice.split("{{ gs('cur_sym') }}");
                let price = parseFloat(splitPrice[1]);
                let totalPrice = quantity * price;
                currentRow.find('.subtotal').text("{{ gs('cur_sym') }}" + totalPrice.toFixed(2));

                subTotal();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    method: "POST",
                    url: "{{ route('cart.update') }}",
                    data: {
                        product_id: product_id,
                        quantity: quantity
                    },
                    success: function (response) {
                        if (response.success) {
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
