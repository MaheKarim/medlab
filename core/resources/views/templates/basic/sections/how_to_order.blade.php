@php
    $howToOrderContent = getContent('how_to_order.content', true);
    $howToOrderElement = getContent('how_to_order.element', orderById: true);
    $downloadUrlElement = getContent('download_url.element', orderById: true);
@endphp

<div class="how-work pt-60">
    <div class="row gy-4">
        <div class="col-xl-4">
            <div class="how-work__thumb">
                <img src="{{ frontendImage('how_to_order', @$howToOrderContent->data_values->image, '306x309') }}" alt="How To Work Image" class="fit-image">
                <a href="{{ @$howToOrderContent->data_values->video_link }}" class="play-button"><span class="icon"><i class="las la-play"></i></span></a>
            </div>
        </div>
        <div class="col-xl-8 ps-lg-5">
            <div class="how-work-item">
                <h4 class="how-work-item__title"> {{ __(@$howToOrderContent->data_values->heading) }} </h4>
                @foreach($howToOrderElement as $element)
                <ul class="work-list">
                    <li class="work-list__item"> {{ __(@$element->data_values->description_text) }}</li>
                </ul>
                @endforeach
                <p class="how-work-item__text">
                    {{ __(@$howToOrderContent->data_values->description) }}
                </p>

                @foreach($downloadUrlElement as $element)
                    <a class="download-link" href="{{ @$element->data_values->link }}" target="_blank">
                        <img src="{{ frontendImage('download_url', @$element->data_values->image, '144x43') }}" alt="app store">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
