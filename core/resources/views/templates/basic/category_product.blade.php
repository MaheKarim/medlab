@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="container custom--container">
            <div class="row gy-4">
                <div class="col-xl-3 col-lg-4">
                    @include($activeTemplate. 'partials.sidebar')
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="Product-wrapper">
                        <ul class="link-list">
                            <li class="link-list__item"><a href="{{ url('/') }}" class="link"> @lang('Home') <i class="las la-angle-right"></i></a></li>
                            <li class="link-list__item"> {{ __($category->name) }} </li>
                        </ul>
                        @if($category->products->isNotEmpty())
                        <div class="row gy-4 mb-4">
                            @foreach($category->products as $product)
                            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                <div class="product-card">
                                    <a href="{{ route('product.details', $product->id) }}" class="product-card__thumb">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $product->image) }}" alt="Product Image">
                                    </a>
                                    <div class="product-card__content">
                                        <p class="product-card__title"> {{ $product->name }} </p>
                                        <a href="#" class="product-card__text"> {{ $product->generic_name }} </a>
                                        <p class="product-card__desc"> {{ $product->brand->name }} </p>
                                        <div class="product-card__bottom">
                                            <h6 class="product-card__price">  @if ($product->discount > 0)
                                                    {{ getMainPrice($product) }}$
                                                    <span class="old-price">{{ getAmount($product->price) }}</span>
                                                @else
                                                    {{ getAmount($product->price) }}$
                                                @endif
                                            </h6>
                                            <span class="add-cart" data-product-id="{{ $product->id }}">@lang('Add To Cart') </span>
                                        </div>
                                    </div>
                                    @if($product->discount > 0)
                                        <span class="product-offer">
                                            {{ getAmount($product->discount) }}
                                            @if($product->discount_type == \App\Constants\Status::FLAT_DISCOUNT)
                                                @lang('Flat')
                                            @else
                                                @lang('%')
                                            @endif
                                            Off
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">

{{--                                    @if($category->hasPages())--}}
{{--                                    <a class="page-link" href="product-details.html">--}}
{{--                                        <i class="las la-angle-left"></i>--}}
{{--                                        {{ paginateLinks($category) }}--}}
{{--                                    </a>--}}
{{--                                     @endif--}}
                                </li>
                            </ul>
                        </nav>
                        <div class="service-item">
                            <h3 class="service-item__title">  {{ $category->name }}   </h3>
                            <p class="service-item__desc"> {{ __($category->description) }} </p>
                        </div>
                        @else
                            <div class="alert alert-danger">
                                @lang('No product found')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
