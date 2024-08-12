@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="container custom--container">
            <div class="row gy-4">
                <div class="col-xl-3 col-lg-4">
                    @include($activeTemplate. 'partials.sidebar')
                </div>
                <div class="col-xl-9 col-lg-8">
                @if(@$sections->secs != null)
                        @foreach(json_decode($sections->secs) as $sec)
                            @include($activeTemplate.'sections.'.$sec)
                        @endforeach
                    @endif
{{--                    @include($activeTemplate. 'partials.products')--}}
                </div>
            </div>
        </div>
    </section>
@endsection
