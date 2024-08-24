@php
    $registrationDisabled = getContent('register_disable.content',true);
@endphp
<section class="account section-bg maintenance-page flex-column justify-content-center">
    <div class="register-disable">
        <div class="container text-center">
            <div class="register-disable-image">
                <img class="fit-image"
                     src="{{ frontendImage('register_disable',@$registrationDisabled->data_values->image,'280x280') }}"
                     alt="Registration Disabled">
            </div>
            <h5 class="register-disable-title mt-4">{{ __(@$registrationDisabled->data_values->heading) }}</h5>
            <p class="register-disable-desc">
                {{ __(@$registrationDisabled->data_values->subheading) }}
            </p>
            <div class="text-center mt-3">
                <a href="{{ @$registrationDisabled->data_values->button_url }}"
                   class="register-disable-footer-link btn btn-sm btn--base">{{ __(@$registrationDisabled->data_values->button_name) }}</a>
            </div>
        </div>
    </div>
</section>

<style>
    .header {
        display: none;
    }
    body, .register-disable {
        background-color: white !important;
        display: flex;
        align-items: center;
        height: 100vh;
        justify-content: center;
    }

    .breadcrumb {
        display: none;
    }

    .footer-area {
        display: none;
    }
</style>
