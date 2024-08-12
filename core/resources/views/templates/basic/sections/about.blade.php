@php
     $aboutContent = getContent('about.content',true);
@endphp
<div class="about-section py-60">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-6">
                <div class="about-thumb">
                    <img src="{{ frontendImage('about' , @$aboutContent->data_values->image, '460x309') }}" class="fit-image" alt="@lang('image')" />
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about-content">
                    <h3 class="about-content__title"> {{ __(@$aboutContent->data_values->heading) }} </h3>
                    <p class="about-content__desc">
                        @php
                            echo __(@$aboutContent->data_values->description)
                        @endphp
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
