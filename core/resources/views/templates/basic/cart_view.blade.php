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
                        $price    = showDiscountPrice($cart->product->price, $cart->product->discount, $cart->product->discount_type);
                    @endphp
                    <tr>
                        <td>
                            <div class="product-item">
                                <div class="product-thumb">
                                    <img
                                        src="{{ getImage(getFilePath('product') . '/' . $cart->product->image, getFileSize('product')) }}"
                                        alt="products">
                                </div>
                                <div class="product-content">
                                    <h6 class="name">
                                        <a href="{{ route('product.details',  $cart->product_id) }}"
                                           class="productName"
                                           data-product_id="{{ $cart->product_id }}">{{ __($cart->product->name) }}</a>
                                    </h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="price">
                                {{ showAmount($price) }}
                            </span>
                        </td>
                        <td>
                            <div class="cart-plus-minus">
                                <input type="number" class="form-control" name="quantity" value="{{ $cart->quantity }}">
                            </div>
                        </td>
                        <td>
                            <span class="subtotal">
                                {{ showAmount($price * $cart->quantity) }}
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
                    <a href="{{ route('home') }}"
                       class="btn btn-outline--primary  btn-lg fs-6 w-100">@lang('Continue Shopping ')
                        <i class="las la-long-arrow-alt-right ms-3"></i>
                    </a>
                </div>

                <div class="col-xl-4">
                    <ul class="cart-details">
                        <li>
                            <h6 class="title">@lang('Subtotal')</h6>
                            <h6 class="value subtotal-price text--base">{{ gs('cur_sym') }}0.00</h6>
                        </li>

                        <li>
                            <a href="{{ route('user.checkout.index') }}"
                               class="checkoutBtn btn btn-outline--primary w-100">@lang('Proceed to Checkout')</a>
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
            let quantity;

            $('input[name="quantity"]').on('focusout keypress', function (e) {
                if (e.type === 'focusout' || (e.type === 'keypress' && e.which === 13)) {
                    currentRow = $(this).closest("tr");
                    quantity = currentRow.find('input[name="quantity"]').val();

                    if (parseInt(quantity) > 0) {
                        CartCalculation(currentRow);
                    } else {
                        currentRow.find('input[name="quantity"]').val(1);
                        CartCalculation(currentRow);
                        notify('error', 'You have to order a minimum amount of one.');
                    }
                }
            });

            $('.remove-btn').on('click', function () {
                removeableItem = $(this).closest("tr");
                modal.modal('show');
            });

            $(".remove-product").on('click', function () {
                let product_id = removeableItem.find('.productName').data('product_id');
                $('.cart-count').val('');
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
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
                modal.modal('hide');
            });

            subTotal();

            function subTotal() {

                let subtotal = 0;

                $('.cart-table tr').each(function () {
                    let currentRow = $(this);
                    let subtotalText = currentRow.find('.subtotal').text().trim();
                    if (subtotalText) {
                        let price = parseFloat(subtotalText.replace("{{ gs('cur_sym') }}", '').replace(/,/g, ''));
                        if (!isNaN(price)) {
                            subtotal += price;
                        }
                    }
                });


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
                let quantity = parseInt(currentRow.find('input[name="quantity"]').val(), 10);
                let productPrice = currentRow.find('.price').text().trim();

                let price = parseFloat(productPrice.replace("{{ gs('cur_sym') }}", '').replace(/,/g, ''));
                if (isNaN(price) || isNaN(quantity) || quantity <= 0) {
                    notify('error', 'Invalid price or quantity.');
                    return;
                }

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
