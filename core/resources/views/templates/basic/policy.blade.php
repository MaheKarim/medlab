@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="about-section py-60">
        <div class="container">
            <div class="row gy-4">
                <div class="page">
                    <div class="page-header">
                        <h5 class="page-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="page-body">
                        @php
                            echo __(@$policy->data_values->details)
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
