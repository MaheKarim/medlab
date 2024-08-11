<div class="col-xl-3 col-lg-4">
    <ul class="category-menu">
        <li class="close-sidebar-icon d-lg-none d-block">
            <i class="las la-times"></i>
        </li>
        @foreach($categories as $category)
        <li class="category-menu__item">
            <a href="medicine.html" class="category-menu__link">
            <span class="category-menu__thumb">
                <img src="{{ getImage(getFilePath('category') .'/' . $category->image, '50x50') }}" alt="Category Image">
            </span> {{ $category->name }}
                <span class="category-menu__icon">
                <i class="fas fa-angle-down"></i>
            </span>
            </a>
        </li>
        @endforeach
    </ul>
</div>
