@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach($orders as $order)
                <div class="col-md-12">
                    @include('admin.partials.order_details')
                </div>
            @endforeach
        </div>
    </div>
@endsection
