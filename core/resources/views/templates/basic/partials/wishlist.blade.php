<div class="cart-sidebar-area">
    <div class="top-content d-flex flex-wrap justify-content-between align-items-center">
        <h4 class="cart-sidebar-area__title">@lang('Your Cart')</h4>
        <button class="side-sidebar-close-btn"><i class="las la-times"></i></button>
    </div>
    @php
        $cart = \App\Models\Cart::where('session_id', session()->get('session_id'))->get();
    @endphp
    <div class="bottom-content">
        <div class="cart-products wish--products">
            @if(!auth()->user() && $cart->isEmpty())
                <div class="single-product-item no_data">
                    <div class="no_data-thumb text-center">
                        <img src="{{ asset('assets/images/cart.webp') }}" alt="">
                    </div>
                    <h6 class="mt-2">@lang('Your cart list is empty')</h6>
                </div>
            @else
                <div class="single-product-item">
                    <div class="thumb">
                        <img src="assets/images/thumbs/pd-2.webp" alt="">
                    </div>
                    <div class="content">
                        <div>
                            <p class="title"> Paracetamol <span class="product-size"> 500mg </span></p>
                            <span class="product-group"> Paracetamol </span>
                            <div class="qty-container">
                                <button class="qty-btn-minus btn-light" type="button"><i class="fa fa-minus"></i></button>
                                <input type="text" name="qty" value="3" class="input-qty"/>
                                <button class="qty-btn-plus btn-light" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <p class="price">$10.00</p>

                    </div>

                </div>
            @endif
            <!-- add to cart  -->
            <!-- add to cart  -->
        </div>
    </div>

    <div class="top-content mt-4">
        <button class="single-product-item__icon btn btn-primary w-100" type="button">
            @lang('Checkout')
        </button>
    </div>
</div>
