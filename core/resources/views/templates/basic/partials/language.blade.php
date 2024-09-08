@if (gs("multi_language"))
    @php
        $language = App\Models\Language::all();
        $selectedLang = $language->where("code", session("lang"))->first();
    @endphp
    <div class="d-block d-lg-none">
        <div class="dropdown-lang dropdown d-block mt-0">
            <a class="language-btn dropdown-toggle" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                <img class="flag" src="{{ getImage(getFilePath("language") . "/" . @$selectedLang->image, getFileSize("language")) }}" alt="us">
                <span class="language-text text-white">{{ __(@$selectedLang->name) }}</span>
            </a>
            <ul class="dropdown-menu">
                @foreach ($language as $lang)
                    <li>
                        <a href="{{ route("lang", $lang->code) }}">
                            <img class="flag" src="{{ getImage(getFilePath("language") . "/" . @$lang->image, getFileSize("language")) }}" alt="@lang("image")">
                            {{ __(@$lang->name) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
