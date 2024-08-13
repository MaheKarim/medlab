@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="notice"></div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($pageTitle) }}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum unde, vitae esse eum perspiciatis consectetur nisi, atque repellendus, cumque magnam ab a inventore quis nobis quod quisquam omnis. In, possimus!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kycRejectionReason">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>MK</p>
                </div>
            </div>
        </div>
    </div>
@endsection
