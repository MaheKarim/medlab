@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card custom--card">
    <div class="card-header">
        <h5 class="card-title">@lang('Profile')</h5>
    </div>
    <div class="card-body">
        <form class="register" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-sm-12">
                    {{-- <label class="form-label">@lang('User Profile')</label>
                    <x-image-uploader image="{{ $user->image }}" class="w-100" type="userProfile" :required=false /> --}}
                        <div class="account__header">
                            <div class="account__header-thumb">
                                <div class="file-upload">
                                    <label class="edit" for="profile-image"><i class="las la-camera"></i></label>
                                    <input type="file" name="image" class="form-control form--control" id="profile-image" hidden="">
                                </div>
                                <div class="thumb">
                                    <img src="http://localhost/medLab/assets/images/frontend/how_to_order/66b8cff75ece91723387895.png" alt="">
                                </div>
                            </div>
                            <div class="account__header-content">
                                <h5 class="name">
                                    {{ __($user->fullName) }}
                                </h5>
                                <p class="account__header-text">
                                    <a href="tel:{{ $user->mobile }}" class="link"><span class="icon"><i class="fas fa-phone"></i></span> {{ $user->mobile }} </a>
                                </p>
                                <p class="account__header-text">
                                    <a href="mailto:{{ $user->email }}" class="link"><span class="icon"><i class="fas fa-paper-plane"></i></span> {{ $user->email }} </a>
                                </p>
                            </div>
                        </div>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('First Name')</label>
                    <input type="text" class="form-control form--control" name="firstname" value="{{$user->firstname}}" required>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('Last Name')</label>
                    <input type="text" class="form-control form--control" name="lastname" value="{{$user->lastname}}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('E-mail Address')</label>
                    <input class="form-control form--control" value="{{$user->email}}" readonly>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('Mobile Number')</label>
                    <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('Address')</label>
                    <input type="text" class="form-control form--control" name="address" value="{{@$user->address}}">
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">@lang('State')</label>
                    <input type="text" class="form-control form--control" name="state" value="{{@$user->state}}">
                </div>
            </div>


            <div class="row">
                <div class="form-group col-sm-4">
                    <label class="form-label">@lang('Zip Code')</label>
                    <input type="text" class="form-control form--control" name="zip" value="{{@$user->zip}}">
                </div>

                <div class="form-group col-sm-4">
                    <label class="form-label">@lang('City')</label>
                    <input type="text" class="form-control form--control" name="city" value="{{@$user->city}}">
                </div>

                <div class="form-group col-sm-4">
                    <label class="form-label">@lang('Country')</label>
                    <input class="form-control form--control" value="{{@$user->country_name}}" disabled>
                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </div>
        </form>
    </div>
</div>
@endsection
