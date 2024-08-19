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
                            @forelse($categories as $category)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ getImage(getFilePath('category').'/'. $category->image, getFileSize('category')) }}"
                                            class="icon" alt="Image">
                                        {{ __($category->name) }}
                                    </td>
                                    <td> @php echo $category->statusBadge @endphp</td>
                                    <td>{{ showDateTime($category->updated_at) }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm editBtn"
                                                    data-modal_title="@lang('Edit category')"
                                                    data-resource="{{ $category }}"
                                                    data-image="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"

                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>

                                            @if ($category->status == Status::ENABLE)
                                                <button
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to disable this category?')"
                                                    data-action="{{ route('admin.category.status',$category->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to enable this category?')"
                                                    data-action="{{ route('admin.category.status',$category->id) }}">
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
                        </table>
                    </div>
                </div>
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />

    <!-- Confirmation Modal Start -->
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Category')</span></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label class="required">@lang('Category Name')</label>
                                <a href="javascript:void(0)" class="buildSlug"><i
                                        class="las la-link"></i> @lang('Make Slug')
                                </a>
                            </div>
                            <input name="name" type="text" class="form-control bg--white pe-2"
                                   placeholder="@lang('Category Name')" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label> @lang('Slug')</label>
                                <div class="slug-verification d-none"></div>
                            </div>
                            <input type="text" class="form-control" name="slug" value="{{old('slug')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="required addImageLabel">@lang('Image')</label>
                            <x-image-uploader name="image" type="category" class="w-100" :required="true"/>
                        </div>
                        <div class="form-group">
                            <label class="required">@lang('Description')</label>
                            <textarea name="description" class="form-control"  required>{{ old('description') }}
                            </textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal End -->
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn addBtn"
            data-modal_title="@lang('Create New Category')" type="button">
        <i class="las la-plus"></i>@lang('Add New Category')</button>
@endpush

@push('script')
    <script>
        'use strict';
        let defaultImage = `{{ getImage(getFilePath('category'), getFileSize('category')) }}`;
        (function ($) {
            $('.addBtn').on('click', function () {
                var modal = $('#cuModal');
                modal.find('.image-upload-preview').css('background-image', `url(${defaultImage})`);
                modal.find('.image-upload-input').attr('required', true);
                modal.find('.addImageLabel').addClass('required');
                // Clear the slug verification element
                modal.find('.slug-verification').addClass('d-none').html('');
                modal.find('[name=slug]').val('');
                modal.find('[name=name]').val('');
            });

            $('.editBtn').click(function () {
                var image = $(this).data('image');
                var modal = $('#cuModal');
                modal.find('.image-upload-preview').css('background-image', `url(${image})`);
                modal.find('.image-upload-input').removeAttr('required', true);
                modal.find('.addImageLabel').removeClass('required');

                modal.find('.slug-verification').addClass('d-none').html('');
                modal.find('[name=slug]').val('');
            });

        })(jQuery);

        $('.buildSlug').on('click', function () {
            let closestForm = $(this).closest('form');
            let title = closestForm.find('[name=name]').val();
            closestForm.find('[name=slug]').val(title);
            closestForm.find('[name=slug]').trigger('input');
        });

        $('[name=slug]').on('input', function () {
            let closestForm = $(this).closest('form');
            closestForm.find('[type=submit]').addClass('disabled')
            let slug = $(this).val();
            slug = slug.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            $(this).val(slug);
            if (slug) {
                $('.slug-verification').removeClass('d-none');
                $('.slug-verification').html(`
                        <small class="text--info"><i class="las la-spinner la-spin"></i> @lang('Checking')</small>
                    `);
                $.get("{{ route('admin.category.check.slug') }}", {slug: slug}, function (response) {
                    if (!response.exists) {
                        $('.slug-verification').html(`
                                <small class="text--success"><i class="las la-check"></i> @lang('Available')</small>
                            `);
                        closestForm.find('[type=submit]').removeClass('disabled')
                    }
                    if (response.exists) {
                        $('.slug-verification').html(`
                                <small class="text--danger"><i class="las la-times"></i> @lang('Slug already exists')</small>
                            `);
                    }
                });
            } else {
                $('.slug-verification').addClass('d-none');
            }
        })
    </script>
@endpush
