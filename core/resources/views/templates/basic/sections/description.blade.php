@php
    $descriptionContent = getContent('description.content',true);
@endphp
<div class="information-section py-60">
    <h3 class="information-section__title">
        {{ __($descriptionContent->data_values->heading) }}
    </h3>
    <div class="information-content">
        <p class="information-content__desc">
            @php echo __($descriptionContent->data_values->description)
            @endphp
        </p>
    </div>
</div>
