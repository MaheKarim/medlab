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
                        <div class="row gy-4 mb-4">
                            @foreach($category->products as $product)
                            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                <div class="product-card">
                                    <a href="product-details.html" class="product-card__thumb">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $product->image) }}" alt="Product Image">
                                    </a>
                                    <div class="product-card__content">
                                        <p class="product-card__title"> {{ $product->name }} </p>
                                        <a href="#" class="product-card__text"> {{ $product->generic_name }} </a>
                                        <p class="product-card__desc"> {{ $product->brand->name }} </p>
                                        <div class="product-card__bottom">
                                            <h6 class="product-card__price"> 5.00$ <span class="old-price"> 7.00$
                                                </span></h6>
                                            <span class="add-cart"> Add to cart </span>
                                        </div>
                                    </div>
                                    <span class="product-offer">
                                        5% Off
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="product-details.html"><i class="las la-angle-left"></i></a></li>
                                <li class="page-item"><a class="page-link" href="product-details.html">1</a></li>
                                <li class="page-item"><a class="page-link" href="product-details.html">2</a></li>
                                <li class="page-item"><a class="page-link" href="product-details.html">3</a></li>
                                <li class="page-item"><a class="page-link" href="product-details.html"><i class="las la-angle-right"></i></a></li>
                            </ul>
                        </nav>
                        <div class="service-item">
                            <h3 class="service-item__title">  {{ $category->name }}   </h3>
                            <p class="service-item__desc"> {{ __($category->description) }} </p>
                        </div>
                        <div class="best-seller">
                            <h3 class="best-seller__title"> Best Selling Products of Sexual Wellness  </h3>
                            <div class="best-seller__wrapper">
                                <a href="product-details.html" class="product-link"> U & Me long Love</a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Sensation Super Dotted Strawberry Condom </a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Panther Dotted </a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> U & Me long Love</a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Sensation Super Dotted Strawberry Condom </a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Panther Dotted </a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> U & Me long Love</a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Sensation Super Dotted Strawberry Condom </a>
                                <span> | </span>
                                <a href="product-details.html" class="product-link"> Panther Dotted </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
