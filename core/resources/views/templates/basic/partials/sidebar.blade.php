<ul class="category-menu">
    <li class="close-sidebar-icon d-lg-none d-block">
        <i class="las la-times"></i>
    </li>
    @foreach($sidebarCategories as $category)
        @php
            $isActive = request()->routeIs('category.products') && request()->slug === $category->slug;
        @endphp
        <li class="category-menu__item {{ $isActive ? 'active' : '' }}">
            <a href="{{ route('category.products', ['slug' => $category->slug]) }}" class="category-menu__link">
            <span class="category-menu__thumb">
                <img src="{{ getImage(getFilePath('category') .'/' . $category->image, '50x50') }}" alt="Category Image">
            </span>
                {{ __($category->name) }}
                <span class="category-menu__icon">
                <i class="fas fa-angle-down"></i>
            </span>
            </a>
        </li>
    @endforeach
</ul>
