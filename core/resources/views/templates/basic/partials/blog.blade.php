@foreach($blogs as $blog)
    <div class="col-xl-4 col-md-6">
        <div class="blog-item">
            <div class="blog-item__thumb">
                <a href="product-details.html" class="blog-item__thumb-link">
                    <img src="{{ frontendImage('blog',  @$blog->data_values->image, '728x465') }}" class="fit-image"
                         alt="Blog Image">
                </a>
            </div>
            <div class="blog-item__content">
                <h6 class="blog-item__title">
                    <a href="product-details.html" class="blog-item__title-link border-effect">
                        {{ __(@$blog->data_values->title) }}
                    </a>
                </h6>
                <p class="blog-item__desc">
                    @php
                        echo strLimit(strip_tags(@$blog->data_values->description), 60);
                    @endphp
                </p>
                <a href="product-details.html" class="btn btn--base btn--sm">Read More <span
                        class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span> </a>
            </div>
        </div>
    </div>
@endforeach
