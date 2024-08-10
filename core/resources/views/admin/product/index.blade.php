@php use App\Constants\Status; @endphp
@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm ">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Product SKU')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Stock Quantity')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <div class="user">
                                            <div class="thumb">
                                                <img src="{{ $product->imageShow() }}" alt="@lang('image')">
                                            </div>
                                            <span class="name">{{ __($product->name) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $product->product_sku }}</td>
                                    <td>
                                        @if($product->discount > 0)
                                            <del>{{ showAmount($product->price) }}</del> <br>
                                            @php
                                                if ($product->discount_type == Status::FLAT_DISCOUNT) {
                                                    $discountedPrice = $product->price - $product->discount;
                                                } elseif ($product->discount_type == Status::PERCENT_DISCOUNT) {
                                                    $discountedPrice = $product->price - ($product->price * $product->discount / 100);
                                                }
                                            @endphp
                                          <b> {{ showAmount($discountedPrice) }} </b>
                                        @else
                                            {{ showAmount($product->price) }}
                                        @endif
                                    </td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @php
                                            echo $product->statusBadge;
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="button--group">
                                            @if (!$product->status)
                                                <button class="btn btn-sm btn-outline--primary confirmationBtn" data-action="{{ route('admin.product.status', $product->id) }}" data-question="@lang('Are you sure to enable this product?')">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.product.status', $product->id) }}" data-question="@lang('Are you sure to disable this product?')">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif
                                            <a class="btn btn-sm btn-outline--primary" type="button"
                                                    href="{{ route('admin.product.edit', $product->id) }}" >
                                                <i class="las la-pen"></i> @lang('Edit')
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">
                                        {{ __($emptyMessage) }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($products) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search here..." />

    <a href="{{ route('admin.product.create') }}" class="btn btn-outline--primary h-45">
        <i class="las la-plus"></i> @lang('Add New')
    </a>
@endpush


@push('style')
    <style>
        .h-45 {
            line-height: 28.5px !important;
        }
    </style>
@endpush
