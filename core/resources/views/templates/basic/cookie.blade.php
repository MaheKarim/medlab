@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="about-section py-60">
        <div class="container">
            <div class="row gy-4">
                <div class="page">
                    <div class="page-title">
                        <h5 class="title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="line">
                        @php
                            echo __(@$cookie->data_values->description)
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
