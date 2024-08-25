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
                        @include($activeTemplate.'sections.banner')

                        @foreach(json_decode(@$sections->secs) as $sec)
                            @continue($sec == 'banner')
                            @include($activeTemplate.'sections.'.$sec)
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
