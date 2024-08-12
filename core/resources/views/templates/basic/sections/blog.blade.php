@php
    $blogsContent = getContent('blog.content',true);
    $blogs = getContent('blog.element',orderById: true);
@endphp
<section class="blog pt-60">
    <div class="section-heading">
        <h5 class="section-heading__title"> {{ __($blogsContent->data_values->heading) }} </h5>
        <div class="section-heading__btn">
            <a href="{{ url('blogs') }}" class="btn btn--base "> View all </a>
        </div>
    </div>
    <div class="row gy-4 justify-content-center">
        @include($activeTemplate.'partials.blog')
    </div>
</section>
