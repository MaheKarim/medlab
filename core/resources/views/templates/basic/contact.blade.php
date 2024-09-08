@extends($activeTemplate.'layouts.frontend')
@php
    $contactUsContent = getContent('contact_us.content', true);
@endphp
@section('content')
    <section class="main-section">
        <div class="container">
            <div class="contact-top">
                <div class="row gy-4">
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-item-menu">
                            <div class="contact-item-menu__icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="contact-item-menu__content">
                                <h5 class="contact-item-menu__title"> @lang('Our Address') </h5>
                                <p class="contact-item-menu__desc"> {{ __(@$contactUsContent->data_values->contact_details) }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-item-menu">
                            <div class="contact-item-menu__icon"><i class="far fa-envelope"></i></div>
                            <div class="contact-item-menu__content">
                                <h5 class="contact-item-menu__title"> @lang('Email Address') </h5>
                                <p class="contact-item-menu__desc"> {{ @$contactUsContent->data_values->email_address }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-item-menu">
                            <div class="contact-item-menu__icon"><i class="fas fa-phone"></i></div>
                            <div class="contact-item-menu__content">
                                <h5 class="contact-item-menu__title"> @lang('Phone Number') </h5>
                                <p class="contact-item-menu__desc"> {{ @$contactUsContent->data_values->contact_number }}  </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-bottom">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="contact-form">
                            <h4 class="contact-form__title"> @lang('Contact With Us') </h4>
                                <form method="post" class="verify-gcaptcha">
                                    @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 col-sm-6 form-group">
                                    <label class="form--label label-two form-label">@lang('Name')</label>
                                    <input name="name" type="text" class="form-control form--control" value="{{ old('name',@$user->fullname) }}" @if($user && $user->profile_complete) readonly @endif required>
                                    </div>

                                    <div class="col-xl-6 col-lg-12 col-sm-6 form-group">
                                        <label class="form-label form--label">@lang('Email')</label>
                                        <input name="email" type="email" class="form-control form--control" value="{{  old('email',@$user->email) }}" @if($user) readonly @endif required>
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label for="sub" class="form--label  label-two"> @lang('Subject') </label>
                                        <input name="subject" type="text" class="form-control form--control" value="{{old('subject')}}" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="mes" class="form--label  label-two">@lang('Message') </label>
                                        <textarea name="message" class="form-control form--control" required>{{old('message')}}</textarea>
                                    </div>
                                </div>
                                    <x-captcha />
                                <div class="contact-form__btn">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-bottom__map">
                            <iframe src="{{ @$contactUsContent->data_values->map_url }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        @if(@$sections->secs != null)
            @foreach(json_decode($sections->secs) as $sec)
                @include($activeTemplate.'sections.'.$sec)
            @endforeach
        @endif
        </div>
    </section>
@endsection
