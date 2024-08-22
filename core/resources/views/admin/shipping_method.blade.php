@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Last Update')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($methods as $method)
                                <tr>
                                    <td>{{ __($method->name) }}</td>
                                    <td>{{ __(showAmount($method->price, currencyFormat: false)) }}</td>
                                    <td>@php echo $method->statusBadge @endphp</td>
                                    <td>{{ showDateTime($method->updated_at) }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm editBtn"
                                                    data-modal_title="@lang('Edit shipping method')"
                                                    data-resource="{{ $method }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>

                                            @if ($method->status == Status::ENABLE)
                                                <button
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to disable this shipping method?')"
                                                    data-action="{{ route('admin.shipping.status',$method->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to enable this shipping method?')"
                                                    data-action="{{ route('admin.shipping.status',$method->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($methods->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($methods) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    <!-- Confirmation Modal Start -->
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Shipping Method')</span></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.shipping.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Shipping Method Name')</label>
                            <input name="name" type="text" class="form-control bg--white pe-2"
                                   placeholder="@lang('Shipping Method Name')" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Price')</label>
                            <div class="input-group">
                            <input name="price" type="number" min="0" class="form-control bg--white pe-2"
                                   placeholder="@lang('Price')" autocomplete="off" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal End -->
    <x-confirmation-modal/>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn addBtn"
            data-modal_title="@lang('Create New Shipping Method')" type="button">
        <i class="las la-plus"></i>@lang('Add New Shipping Method')</button>
@endpush
