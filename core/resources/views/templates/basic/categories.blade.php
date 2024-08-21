@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="container custom--container">
            <div class="row gy-4">
                <div class="col-xl-3 col-lg-4">
                    @include($activeTemplate. 'partials.sidebar')
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="product-category-wrapper">
                        <h6 class="title"> @lang('All Categories') </h6>
                        <div class="row gy-4">
                            @foreach($categories as $category)
                                <div class="col-xl-3 col-lg-4 col-sm-3 col-xsm-6">
                                    <div class="product-item">
                                            <div class="product-item__thumb">
                                                <a href="{{ route('category.products', $category->slug) }}">
                                                <img
                                                    src="{{ getImage(getFilePath('category') . '/' . $category->image) }}"
                                                    alt="Category Image">
                                                </a>
                                            </div>
                                        <p class="product-item__text"> {{ __($category->name) }} </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
