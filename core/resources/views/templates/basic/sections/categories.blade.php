@php
    $categoryData = getContent('categories.content',orderById: true)->first();
@endphp

<div class="product-category">
    <div class="section-heading">
        <h5 class="section-heading__title"> {{ __(@$categoryData->data_values->heading) }} </h5>
        <div class="section-heading__btn">
            <a href="{{ route('all.category') }}" class="btn btn--base "> @lang('View All') </a>
        </div>
    </div>
    <div class="product-slider mt-2">
        @foreach(@$sidebarCategories as $category)
            <div>
                <div class="product-item">
                    <div class="product-item__thumb">
                        <img src="{{ getImage(getFilePath('category') .'/' . $category->image, '50x50') }}" alt="Category Image">
                    </div>
                    <p class="product-item__text"> {{ __($category->name) }} </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
