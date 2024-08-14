@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="about-section py-60">
        <div class="container">
            <div class="row gy-4">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            echo __(@$cookie->data_values->description)
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
