@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog py-80">
        <div class="container pt-5">
            <div class="row gy-4">
                @include($activeTemplate . 'partials.blog')
            </div>
            {{ paginateLinks($blogs) }}
        </div>
    </section>

@endsection
