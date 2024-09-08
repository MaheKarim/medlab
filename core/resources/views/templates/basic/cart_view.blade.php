@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="cart-section py-60 bg-white">
        <div class="container">
            <div class="cart-header">
                <div class="cart">
                    <div class="cart-body">
                        @if ($carts->isEmpty())
                            <div class="text-center py-5">
                                <h5>@lang('No Cart found')</h5>
                            </div>
                        @else
                            @foreach ($carts as $cart)
                                @php
                                    $user = auth()->user() ?? null;
                                    $price = showDiscountPrice(
                                        $cart->product->price,
                                        $cart->product->discount,
                                        $cart->product->discount_type,
                                    );
                                @endphp
                                <div class="cart-item">
                                    <div class="cart-item__content">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $cart->product->image, getFileSize('product')) }}"
                                                alt="@lang($cart->product->name)">
                                        </div>
                                        <div class="inner-content">
                                            <small class="inner-content__name">
                                                @lang('Brand:') {{ __($cart->product->brand->name) }}
                                            </small>
                                            <a href="{{ route('product.details', $cart->product_id) }}" class="productName"
                                                data-product_id="{{ $cart->product_id }}">
                                                {{ __($cart->product->name) }}
                                            </a>
                                            <div class="size">
                                                <div>
                                                    <span class="size__text">@lang('Price:')</span>
                                                    <span class="price">{{ showAmount($price) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qty-container">
                                        <button class="qty-btn-minus btn-light" type="button"><i
                                                class="fa fa-minus"></i></button>
                                        <input type="number" class="form-control input-qty" name="quantity"
                                            value="{{ $cart->quantity }}">
                                        <button class="qty-btn-plus btn-light" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="d-flex flex-column text-center">
                                        <span class="amount">@lang('Price')</span>
                                        <span class="fs-16">
                                            <span class="subtotal">{{ showAmount($price * $cart->quantity) }}</span>
                                        </span>
                                    </div>
                                    <button class="btn--danger remove-btn"><i class="las la-trash"></i></button>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-end coupon-content">
                                <div class="text-end fs-16 price-content">
                                    <small class="price-title d-block">@lang('Total Price') </small>
                                    <span class="cartSubtotal value total-price">{{ gs('cur_sym') }}0.00</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if (!$carts->isEmpty())
                    <div class="checkout-btn text-end">
                        <a href="{{ route('user.checkout.index') }}" class="btn btn--base checkoutBtn"> @lang('Checkout')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeCartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title">@lang('Confirmation Alert!')</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <i class="las la-times"></i></span></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this product?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--base remove-product">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            let removeableItems = [];
            let modal = $('#removeCartModal');

            // Handle individual item removal
            $('.remove-btn').on('click', function() {
                removeableItems = [$(this).closest('.cart-item')];
                modal.modal('show');
            });

            // Confirm and remove product(s)
            $(".remove-product").on('click', function() {
                let productIds = removeableItems.map(function(item) {
                    return $(item).find('.productName').data('product_id');
                });

                // Make an AJAX request to remove the product(s)
                if (productIds.length > 0) {
                    $.ajax({
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('cart.remove') }}",
                        data: {
                            product_id: productIds
                        },
                        success: function(response) {
                            if (response.success) {
                                removeableItems.forEach(function(item) {
                                    item.remove();
                                });
                                getCartCount();
                                 calculationTotal();
                                notify('success', response.success);

                                if ($('.cart-item').length === 0) {
                                    $('.price-content').addClass('d-none');
                                    $('.checkoutBtn').addClass('d-none');
                                    $('.cart-body').html(
                                        '<div class="text-center py-5"><h5>@lang('No Cart found')</h5></div>'
                                        );
                                }
                            } else {
                                notify('error', response.error);
                            }
                        }
                    });
                }

                modal.modal('hide');
            });

            // Cart Calculation
            getCartCount();

            function getCartCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('cart.getCartTotal') }}",
                    success: function(response) {
                        $('.cart-count').text(response);
                    }
                });
            }

             calculationTotal();

            function calculationTotal() {
                let subtotal = 0;
                $('.cart-item').each(function() {
                    let subtotalText = $(this).find('.subtotal').text().trim();
                    if (subtotalText) {
                        let price = parseFloat(subtotalText.replace("{{ gs('cur_sym') }}", '').replace(/,/g,
                            ''));
                        if (!isNaN(price)) {
                            subtotal += price;
                        }
                    }
                });

                $('.total-price').text("{{ gs('cur_sym') }}" + subtotal.toFixed(2));

                // Show/hide checkout button and price section based on subtotal
                if (subtotal > 0) {
                    $('.checkoutBtn').removeClass('d-none');
                    $('.price-content').removeClass('d-none');
                } else {
                    $('.checkoutBtn').addClass('d-none');
                    $('.price-content').addClass('d-none');
                    if ($('.cart-item').length === 0) {
                        $('.cart-body').html('<div class="text-center py-5"><h5>@lang('No Cart found!')</h5></div>');
                    }
                }
            }

            $('.qty-btn-plus, .qty-btn-minus').on('click', function() {
                let input = $(this).siblings('.input-qty');
                let currentValue = parseInt(input.val());
                let newValue = $(this).hasClass('qty-btn-plus') ? currentValue + 1 : currentValue-1;
                input.val(newValue).trigger('change');
            });

            $('.input-qty').on('change', function() {
                let currentRow = $(this).closest('.cart-item');
                updateQty(currentRow);
            });

            function updateQty(currentRow) {
                let product_id = currentRow.find('.productName').data('product_id');
                let quantity = currentRow.find('input[name="quantity"]').val();

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    method: "POST",
                    url: "{{ route('cart.update') }}",
                    data: {
                        product_id: product_id,
                        quantity: quantity || 1
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.cart-count').text(response.total_cart_count);
                            currentRow.find('.subtotal').text(response.subtotal);
                            currentRow.find('input[name="quantity"]').val(response.quantity);
                            calculationTotal();
                        } else {
                            notify('error',"@lang('Something went wrong')");
                        }
                    },
                    error: function() {
                        notify('error',"@lang('Something went wrong')");
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
