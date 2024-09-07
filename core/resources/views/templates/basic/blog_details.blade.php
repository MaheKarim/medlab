@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="blog-detials my-60">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-xxl-8 col-lg-7">
                    <div class="blog-details">
                        <div class="blog-details__thumb wow fadeInUp" data-wow-duration="2s">
                   <img src="{{ frontendImage('blog',@$blog->data_values->image,'728x465') }}" class="fit-image" alt="Blog">
                        </div>
                        <div class="blog-details__content">
                            <div class="d-flex align-items-center gap-3 flex-wrap wow fadeInUp" data-wow-duration="2s">
                                <span class="blog-item__text">
                                <span class="blog-item__text-icon"><i class="fa-solid fa-calendar-check"></i></span> {{ __(showDateTime(@$blog->created_at)) }}
                            </span>
                            </div>
                            <h3 class="blog-details__title wow fadeInUp" data-wow-duration="2s"> {{ __(@$blog->data_values->title) }} </h3>
                            <p class="blog-details__desc wow fadeInUp" data-wow-duration="2s">
                                @php echo @$blog->data_values->description @endphp
                            </p>
                            <div class="blog-details__share">
                                <p class="blog-details__share-title wow fadeInUp" data-wow-duration="2s"> @lang('Share this post')</p>
                                <div class="flex-between gap-3">
                                    <ul class="social-list wow fadeInUp" data-wow-duration="2s">
                                        <li class="social-list__item">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-list__link flex-center"><i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a  href="https://twitter.com/intent/tweet?text= {{ __(strLimit($blog->data_values->title, 150)) }}&amp;url={{ urlencode(url()->current()) }}" class="social-list__link flex-center">
                                                <i class="fa-brands fa-x-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a  href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __(strLimit($blog->data_values->title, 150)) }}&amp;summary={{ __(strLimit(strip_tags(@$blog->data_values->description_nic), 300)) }}" class="social-list__link flex-center">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __(@$blog->data_values->title) }}&media={{ frontendImage('blog', $blog->data_values->image, '966x450') }}" class="social-list__link flex-center"> <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar__bottom">
                            <div class="blog-sidebar">
                                <h6 class="blog-sidebar__title wow fadeInUp" data-wow-duration="2s"> @lang('Related Posts') </h6>
                                @foreach($latestBlogs as $blog)
                                <div class="latest-blog wow fadeInUp" data-wow-duration="2s">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog.details', $blog->slug) }}"> <img src="{{ frontendImage('blog', $blog->data_values->image) }}" class="fit-image" alt=""></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <span class="latest-blog__date"> {{ __(showDateTime($blog->created_at)) }} </span>
                                        <h6 class="latest-blog__title"><a href="{{ route('blog.details', $blog->slug) }}"> {{ __($blog->data_values->title) }} </a>
                                        </h6>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- ============================= Blog Details Sidebar End ======================== -->
                </div>
            </div>
        </div>
    </section>
@endsection
@push('fbComment')
	@php echo loadExtension('fb-comment') @endphp
@endpush
