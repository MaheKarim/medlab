@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.product.store', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-header">@lang('Product Information')</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>@lang('Name')</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>@lang('Brands')</label>
                                <select class="form-control select2" name="brand_id" required>
                                    <option value="" selected disabled>@lang('Select One')</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected(@$product->brand_id == $brand->id)>{{ __($brand->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>@lang('Category')</label>
                                <select name="category_id" class="form-control select2" required>
                                    <option selected disabled>@lang('Select One')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(@$product->category_id == $category->id) data-subcategories="{{ $category->subcategories }}">
                                            {{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>@lang('Product SKU')</label>
                                <input type="text" name="product_sku" class="form-control" value="{{ $product->product_sku }}" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label>@lang('Stock Quantity')</label>
                                <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label>@lang('Price')</label>
                                <div class="input-group">
                                    <input type="number" step="any" name="price" min="0" class="form-control" value="{{ old('price', getAmount(@$product->price)) }}" required />
                                    <span class="input-group-text"> {{ __(gs('cur_text')) }} </span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>@lang('Discount')</label>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" name="discount" min="0" value="{{ old('discount', $product->discount) }}"/>
                                    <select name="discount_type" class="input-group-text">
                                        <option value="1" @selected($product->discount_type == Status::FLAT_DISCOUNT)>{{ __(gs('cur_text')) }}</option>
                                        <option value="2" @selected($product->discount_type == Status::PERCENT_DISCOUNT)>@lang('%')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>@lang('Strength')</label>
                                <input type="text" name="strength" class="form-control" value="{{ old('strength', @$product->strength) }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>@lang('Generic Name')</label>
                                <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name', $product->generic_name) }}"/>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card mb-3">
                    <div class="card-header">@lang('Product Details')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Summary')</label>
                            <textarea name="summary" class="form-control" cols="2" rows="5" required>{{ $product->summary }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea rows="5" class="form-control nicEdit" name="description">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Benefits')</label>
                            <textarea rows="5" class="form-control nicEdit" name="benefits">{{ $product->benefits }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Services')</label>
                            <textarea rows="5" class="form-control nicEdit" name="service">{{ $product->service }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"> @lang('Image Section') </div>
                    <div class="card-body">
                        <div class="image-uploader-wrapper">
                            <div class="profile-uploader">
                                <label class="form-group">@lang('Main Image') :</label>
                                <div class="payment-method-item">
                                    <div class="payment-method-header d-flex flex-wrap">
                                        <div class="thumb">
                                            <div class="avatar-preview">

                                            </div>
                                            <div class="avatar-edit">
                                                <x-image-uploader image="{{ @$product->image }}" class="w-100" type="product" :required=false/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-uploader">
                                <label class="form-label required">@lang('Gallery Image') :</label>
                                <div class="input-field">
                                    <div class="input-images"></div>
                                    <small class="form-text text-muted">
                                        <label><i class="las la-info-circle"></i> @lang('You can only upload maximum of 6 images')</label>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <button type="submit mt-4" class="btn btn--primary w-100 h-45 mt-2">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.product.index') }}" />
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/image-uploader.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/image-uploader.min.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let oldSubcategory = "{{ $product->subcategory_id }}";

            @if (!empty($galleries))
            let preloaded = @json($galleries);
            @endif

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'gallery',
                preloadedInputName: 'old',
                maxFiles: 6
            });

            $(document).on('input', 'input[name="gallery[]"]', function() {
                var fileUpload = $("input[type='file']");
                if (parseInt(fileUpload.get(0).files.length) > 6) {
                    $('#errorModal').modal('show');
                }
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .bodywrapper__inner{
            position: relative;
        }
    </style>
@endpush
