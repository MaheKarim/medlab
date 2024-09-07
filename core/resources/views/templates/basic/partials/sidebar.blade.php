<ul class="category-menu">
    <li class="close-sidebar-icon d-lg-none d-block">
        <i class="las la-times"></i>
    </li>
    @foreach($sidebarCategories as $category)
        <li class="category-menu__item {{ menuActive('category.products',null,$category->slug)}}">
            <a href="{{ route('category.products',$category->slug) }}" class="category-menu__link">
            <span class="category-menu__thumb">
                <img src="{{ getImage(getFilePath('category') .'/' . $category->image,getFileSize('category') ) }}" alt="Category Image">
            </span>
                {{ __($category->name) }}
                <span class="category-menu__icon">
                <i class="fas fa-angle-down"></i>
            </span>
            </a>
        </li>

    @endforeach
    <li>
        <div class="d-block d-lg-none">
            <div class="dropdown-lang dropdown d-block mt-0">
                <a class="language-btn dropdown-toggle" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <img class="flag" src="http://localhost/medLab/assets/images/language/660b94fa876ac1712035066.png" alt="us">
                    <span class="language-text">English</span>
                </a>
                <ul class="dropdown-menu">
                                                            <li>
                            <a href="http://localhost/medLab/change/en">
                                <img class="flag" src="http://localhost/medLab/assets/images/language/660b94fa876ac1712035066.png" alt="image">
                                English
                            </a>
                        </li>
                                                            <li>
                            <a href="http://localhost/medLab/change/bn">
                                <img class="flag" src="http://localhost/medLab/assets/images/language/66c1fc71906051723989105.png" alt="image">
                                Bangla
                            </a>
                        </li>
                                                    </ul>
            </div>
        </div>
    </li>
</ul>
