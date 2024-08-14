@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="container custom--container">
            <!-- ==================== product details Start Here ==================== -->
            <div class="product-details-section">
                <div class="container">
                    <ul class="link-list">
                        <li class="link-list__item"><a href="{{ url('/') }}" class="link"> @lang('Home') <i class="las la-angle-right"></i></a></li>
                        <li class="link-list__item"><a href="{{ route('category.products', $product->category->slug) }}" class="link">{{ $product->category->name }}  <i class="las la-angle-right"></i></a></li>
                        <li class="link-list__item"> Product Details </li>
                    </ul>
                    <div class="row gy-4">
                        <div class="col-lg-6 pe-lg-5">
                            <div class="product-details__wrapper">
                                <div class="product-details__item">
                                    <img src="{{ getImage(getFilePath('product') . '/'. $product->image, getFileSize('product')) }}" alt="{{ $product->name }}">
{{--                                    @foreach($product->gallery ?? [] as $gallery)--}}
{{--                                        <div class="product-details__item">--}}
{{--                                            <img src="{{ getImage(getFilePath('productGallery') . '/'. $gallery, getFileSize('productGallery')) }}" alt="{{ $product->name }}">--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
                                </div>
                            </div>
                            <div class="product-details__gallery">
                                @foreach($product->gallery ?? [] as $gallery)
                                    <div class="product-gallery__item">
                                        <img src="{{ getImage(getFilePath('productGallery') . '/'. $gallery, getFileSize('productGallery')) }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 ps-lg-5">
                            <div class="product-details__right">
                                <h3 class="product-details__right-title"> {{ __($product->name) }} </h3>
                                <span class="product-details__text"> {{ $product->generic_name }} </span>
                                <h6 class="product-price"> Price {{ getAmount($product->price) }}</h6>
                                <p class="product-details__right-desc">
                                    {{ __($product->summary) }}
                                </p>
                                <div class="product-details__quantity d-flex">
                                    <div class="qty-container">
                                        <button class="qty-btn-minus btn-light" type="button"><i class="fa fa-minus"></i></button>
                                        <input type="text" name="quantity" value="1" class="input-qty"/>
                                        <button class="qty-btn-plus btn-light" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-details__btn">
                                    <button class="btn btn--base w-100 cart-add-btn" data-product-id="{{ $product->id }}">Add Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-details__tab">
                                <ul class="nav nav-pills custom--tab" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-descrip-tab" data-bs-toggle="pill" data-bs-target="#pills-descrip" type="button" role="tab" aria-controls="pills-descrip" aria-selected="true"> Description </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-seller-tab" data-bs-toggle="pill" data-bs-target="#pills-seller" type="button" role="tab" aria-controls="pills-seller" aria-selected="false"> Benefits </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-service-tab" data-bs-toggle="pill" data-bs-target="#pills-service" type="button" role="tab" aria-controls="pills-service" aria-selected="false"> Services </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-descrip" role="tabpanel" aria-labelledby="pills-descrip-tab" tabindex="0">
                                        <div class="product-description">
                                            <p class="product-description__desc">
                                                @php echo $product->description; @endphp
                                            </p>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-seller" role="tabpanel" aria-labelledby="pills-seller-tab" tabindex="0">
                                        <div class="benefit">
                                            <p class="benefit__desc mb-0">
                                                @php echo $product->benefits; @endphp
                                            </p>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-service" role="tabpanel" aria-labelledby="pills-service-tab" tabindex="0">
                                        <div class="service-wrapper mt-0">
                                            <div class="service-item">
                                                <p class="service-item__desc"> @php echo $product->service @endphp </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ==================== product details End Here ==================== -->
        </div>
    </section>
@endsection
