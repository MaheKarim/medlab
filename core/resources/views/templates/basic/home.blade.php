@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate. 'partials.sidebar')

{{--    <div class="col-xl-9 col-lg-8 col-lg-8">--}}

{{--        <!-- Banner Section Code -->--}}
{{--    </div>--}}

    @if(@$sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif

@endsection

@push('style')

@endpush
