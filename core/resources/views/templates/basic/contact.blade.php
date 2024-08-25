@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="main-section">
        <div class="row justify-content-center custom--container">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">{{ __($pageTitle) }}</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="verify-gcaptcha">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Name')</label>
                            <input name="name" type="text" class="form-control form--control" value="{{ old('name',@$user->fullname) }}" @if($user && $user->profile_complete) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Email')</label>
                            <input name="email" type="email" class="form-control form--control" value="{{  old('email',@$user->email) }}" @if($user) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Subject')</label>
                            <input name="subject" type="text" class="form-control form--control" value="{{old('subject')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" class="form-control form--control" required>{{old('message')}}</textarea>
                        </div>
                        <x-captcha />
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
            @if(@$sections->secs != null)
                @foreach(json_decode($sections->secs) as $sec)
                    @include($activeTemplate.'sections.'.$sec)
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
