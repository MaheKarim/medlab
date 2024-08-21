@extends($activeTemplate . 'layouts.app')
@section('app')
    @include($activeTemplate . 'partials.header')
    <main>
        @yield('content')
    </main>
    @include($activeTemplate . 'partials.footer')
@endsection
