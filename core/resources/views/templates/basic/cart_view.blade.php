@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="cart-section py-60 bg-white">
        <div class="container">
            <div class="cart-header">
                <div class="status-check d-flex align-items-center justify-content-between gap-3 mb-4">
                    <div class="form-check form--check all">
                        <input class="form-check-input checkAll" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            @lang('Select All')
                        </label>
                    </div>
                    <button type="button" class="btn btn--base btn--sm clear-all">@lang('Clear All')</button>
                </div>
                <div class="cart">
                    <div class="cart-body">
                        @foreach ($carts as $cart)
                            @php
                                $user     = auth()->user() ?? null;
                                $price    = showDiscountPrice($cart->product->price, $cart->product->discount, $cart->product->discount_type);
                            @endphp
                            <div class="cart-item">
                                <div class="cart-item__content">
                                    <div class="form-check form--check">
                                        <input class="form-check-input input-check" type="checkbox" value="">
                                    </div>
                                    <div class="thumb">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $cart->product->image, getFileSize('product')) }}"
                                             alt="@lang($cart->product->name)">
                                    </div>
                                    <div class="inner-content">
                                        <small class="inner-content__name">
                                            @lang('Brand:') {{ __($cart->product->brand->name) }}
                                        </small>
                                        <a href="{{ route('product.details',  $cart->product_id) }}" class="productName"
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
                                    <button class="qty-btn-minus btn-light" type="button"><i class="fa fa-minus"></i></button>
                                    <input type="number" class="form-control input-qty" name="quantity" value="{{ $cart->quantity }}">
                                    <button class="qty-btn-plus btn-light" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <span class="amount">@lang('Subtotal Price')</span>
                                    <span class="fs-16">
                                        <span class="subtotal">{{ showAmount($price * $cart->quantity) }}</span>
                                    </span>
                                </div>
                                <button class="btn--danger remove-btn"><i class="las la-trash"></i></button>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end coupon-content">
                            <div class="text-end fs-16">
                                <small class="price-title d-block">@lang('Total Price') </small>
                                <span class="cartSubtotal value total-price">{{ gs('cur_sym') }}0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkout-btn text-end">
                    <a href="{{ route('user.checkout.index') }}" class="btn btn--base checkoutBtn"> @lang('Checkout') </a>
                </div>
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
        (function ($) {
            "use strict";

            let removeableItems = [];
            let modal = $('#removeCartModal');

            // Select or deselect all checkboxes
            $('.checkAll').on('change', function () {
                $('.input-check').prop('checked', $(this).is(':checked'));
            });

            // Handle 'Clear All' button click
            $('.clear-all').on('click', function () {
                removeableItems = [];
                $('.input-check:checked').each(function () {
                    let cartItem = $(this).closest('.cart-item');
                    removeableItems.push(cartItem);
                });

                if (removeableItems.length === 0) {
                    notify('error', 'No items selected to remove.');
                    return;
                }
                modal.modal('show');
            });

            // Handle individual item removal
            $('.remove-btn').on('click', function () {
                removeableItems = [$(this).closest('.cart-item')];
                modal.modal('show');
            });

            // Confirm and remove product(s)
            $(".remove-product").on('click', function () {
                let productIds = removeableItems.map(function (item) {
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
                        success: function (response) {
                            if (response.success) {
                                removeableItems.forEach(function (item) {
                                    item.remove();
                                });
                                getCartCount();
                                subTotal();
                                notify('success', response.success);
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
                    success: function (response) {
                        $('.cart-count').text(response);
                    }
                });
            }

            subTotal();

            function subTotal() {
                let subtotal = 0;
                $('.cart-item').each(function () {
                    let subtotalText = $(this).find('.subtotal').text().trim();
                    if (subtotalText) {
                        let price = parseFloat(subtotalText.replace("{{ gs('cur_sym') }}", '').replace(/,/g, ''));
                        if (!isNaN(price)) {
                            subtotal += price;
                        }
                    }
                });
                $('.total-price').text("{{ gs('cur_sym') }}" + subtotal.toFixed(2));

                // Show/hide checkout button based on subtotal
                if (subtotal > 0) {
                    $('.checkoutBtn').removeClass('d-none');
                } else {
                    $('.checkoutBtn').addClass('d-none');
                }
            }


            function initializeQuantityButtons() {
                $('.qty-btn-plus, .qty-btn-minus').on('click', function() {
                    let input = $(this).siblings('.input-qty');
                    let currentValue = parseInt(input.val(), 10);
                    let newValue = $(this).hasClass('qty-btn-plus') ? currentValue + 1 : Math.max(currentValue - 1, 1);
                    input.val(newValue).trigger('change');
                });

                $('.input-qty').on('change', function() {
                    let currentRow = $(this).closest('.cart-item');
                    CartCalculation(currentRow);
                });
            }
            initializeQuantityButtons();

            function CartCalculation(currentRow) {
                let product_id = currentRow.find('.productName').data('product_id');
                let quantity = parseInt(currentRow.find('input[name="quantity"]').val(), 10);
                let productPrice = currentRow.find('.price').text().trim();

                let price = parseFloat(productPrice.replace("{{ gs('cur_sym') }}", '').replace(/,/g, ''));
                if (isNaN(price) || isNaN(quantity) || quantity <= 0) {
                    notify('error', 'Invalid price or quantity.');
                    return;
                }

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
                            let totalPrice = quantity * price;
                            currentRow.find('.subtotal').text("{{ gs('cur_sym') }}" + totalPrice.toFixed(2));
                            currentRow.find('input[name="quantity"]').val(quantity);
                            subTotal();
                            getCartCount();
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                            // Revert the quantity to the last known good value
                            currentRow.find('input[name="quantity"]').val(response.quantity);
                        }
                    },
                    error: function() {
                        notify('error', 'An error occurred while updating the cart.');
                        // Revert the quantity to the original value
                        currentRow.find('input[name="quantity"]').val(originalQuantity);
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
