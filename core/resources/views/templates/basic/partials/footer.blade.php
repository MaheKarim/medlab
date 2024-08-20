@php
    $downloadUrlElement = getContent('download_url.element', orderById: true);
    $contactUsContent = getContent('contact_us.content', true);
    $policyPages = getContent('policy_pages.element', orderById: true);
    $socialLinks = getContent('social_icon.element', orderById: true);
@endphp
<footer class="footer-area">
    <div class="py-60">
        <div class="container">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-3 col-sm-6 col-xsm-6 ">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a class="logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="Site Logo"></a>
                        </div>
                        <p class="footer-item__desc"> {{ __(@$contactUsContent->data_values->description) }} </p>

                        <div class="download-item">
                            <p class="download-item__text">@lang('Over') <span
                                    class="fw-bold">{{ __(@$contactUsContent->data_values->download) }} </span>@lang(' people
                                download')</p>
                            <div class="d-flex align-items-center gap-3">
                                @foreach($downloadUrlElement as $element)
                                    <a href="{{ @$element->data_values->link }}" class="download-item__link"
                                       target="_blank">
                                        <img
                                            src="{{ frontendImage('download_url', @$element->data_values->image, '144x43') }}"
                                            alt="App Store Image">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xsm-6 ps-lg-5">
                    <div class="footer-item">
                        <h5 class="footer-item__title"> @lang('Information') </h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item"><a href="{{ route('home') }}" class="footer-menu__link">@lang('Home')</a></li>
                            <li class="footer-menu__item"><a href="{{ route('blogs') }}" class="footer-menu__link">@lang('Blog')</a></li>
                            <li class="footer-menu__item"><a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact')</a></li>
                            @foreach (@$policyPages as $policy)
                                <li class="footer-menu__item">
                                    <a href="{{ route('policy.pages', slug(@$policy->data_values->title)) }}"
                                       class="footer-menu__link"> {{ __($policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"> @lang('Categories') </h5>
                        <ul class="footer-menu">
                            @foreach($sidebarCategories->take(5) as $category)
                                <li class="footer-menu__item"><a
                                        href="{{ route('category.products', $category->slug) }}"
                                        class="footer-menu__link"> {{__($category->name)}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"> {{ __(@$contactUsContent->data_values->title) }} </h5>
                        <ul class="footer-contact-menu">
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{ __(@$contactUsContent->data_values->contact_details) }}</p>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{ __(@$contactUsContent->data_values->contact_number) }}</p>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <p>{{ __(@$contactUsContent->data_values->email_address) }}</p>
                                </div>
                            </li>
                        </ul>
                        <ul class="social-list">
                            @foreach (@$socialLinks as $socialLink)
                                <li class="social-list__item">
                                    <a href="{{ @$socialLink->data_values->url }}" class="social-list__link flex-center"
                                       target="_blank">
                                        @php
                                            echo @$socialLink->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End-->

    <!-- bottom Footer -->
    <div class="bottom-footer py-3">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-12 text-center">
                    <div class="bottom-footer-text text-white"> &copy; Copyright {{ now()->year }}
                        , {{ config('app.name') }} . @lang('All rights reserved.')
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
