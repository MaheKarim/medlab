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
                                <th>@lang('Status')</th>
                                <th>@lang('Last Update')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subcategories as $subcategory)
                                <tr>
                                    <td>
                                        <span class="fw-bold"> {{ $subcategory->category->name }} </span>
                                        / {{ $subcategory->name }}</td>
                                    <td>@php echo $subcategory->statusBadge @endphp</td>
                                    <td>{{ showDateTime($subcategory->updated_at) }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm editBtn"
                                                    data-modal_title="@lang('Edit Sub Category')"
                                                    data-resource="{{ $subcategory }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>

                                            @if ($subcategory->status == Status::ENABLE)
                                                <button
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to disable this sub category?')"
                                                    data-action="{{ route('admin.subcategory.status',$subcategory->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to enable this sub category?')"
                                                    data-action="{{ route('admin.subcategory.status',$subcategory->id) }}">
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
                @if ($subcategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subcategories) }}
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
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Sub Category')</span></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.subcategory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required">@lang('Category')</label>
                            <select name="category_id" class="form-control select2 bg--white" required>
                                <option value="">@lang('Select Category')</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="required">@lang('Sub Category Name')</label>
                            <input name="name" type="text" class="form-control  pe-2"
                                   placeholder="@lang('Sub Category Name')" autocomplete="off">
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
            data-modal_title="@lang('Create New Sub-Category')" type="button">
        <i class="las la-plus"></i>@lang('Add New Sub-Category')</button>
@endpush

@push('script')
    <script>
        "use strict";
        $('.cuModalBtn').on('click', function () {
            $('#cuModal form')[0].reset();
            $('.select2').val(null).trigger('change');
        });
    </script>
@endPush
