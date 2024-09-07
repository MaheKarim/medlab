<!doctype html>
<html lang="{{ config("app.locale") }}" itemscope itemtype="http://schema.org/WebPage">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> {{ gs()->siteName(__($pageTitle)) }}</title>

        @include("partials.seo")

        <link href="{{ asset("assets/global/css/bootstrap.min.css") }}" rel="stylesheet">

        <link href="{{ asset("assets/global/css/all.min.css") }}" rel="stylesheet">

        <link href="{{ asset("assets/global/css/line-awesome.min.css") }}" rel="stylesheet">
        <link href="{{ asset("assets/global/css/select2.min.css") }}" rel="stylesheet">
        <link href="{{ asset($activeTemplateTrue . "css/main.css") }}" rel="stylesheet">
        <link href="{{ asset($activeTemplateTrue . "css/custom.css") }}" rel="stylesheet">
        @stack("style-lib")

        @stack("style")

        <link href="{{ asset($activeTemplateTrue . "css/color.php") }}?color={{ gs("base_color") }}" rel="stylesheet">

    </head>
    @php echo loadExtension('google-analytics') @endphp

    <body>
        @include($activeTemplate . "partials.header")
        @php
            $user = auth()->user() ?? null;
        @endphp
        <div class="page-wrapper">
            <div class="dashboard">
                <div class="container">

                    <div class="row">
                        <div class="col-xl-3">
                            @include($activeTemplate . "partials.sidebar_master")
                        </div>
                        <div class="col-xl-9">
                            <div class="dashboard-body__bar">
                                <span class="dashboard-body__bar-icon"><i class="las la-list"></i></span>
                            </div>
                            <div class="sidebar-overlay"></div>
                            @yield("content")
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include($activeTemplate . "partials.footer")

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{ asset("assets/global/js/jquery-3.7.1.min.js") }}"></script>
        <script src="{{ asset("assets/global/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset("assets/global/js/select2.min.js") }}"></script>
        <script src="{{ asset($activeTemplateTrue . "js/main.js") }}"></script>

        @stack("script-lib")

        @include("partials.notify")

        @php echo loadExtension('tawk-chat') @endphp

        @if (gs("pn"))
            @include("partials.push_script")
        @endif

        @stack("script")

        <script>
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "{{ route("home") }}/change/" + $(this).val();
                });

                $('.select2').each(function(index, element) {
                    $(element).select2();
                });


                $('.select2-basic').each(function(index, element) {
                    $(element).select2();
                });

                var inputElements = $('[type=text],[type=password],select,textarea');
                $.each(inputElements, function(index, element) {
                    element = $(element);
                    element.closest('.form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.attr('name'))
                });

                $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {

                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }

                });


                $('.showFilterBtn').on('click', function() {
                    $('.responsive-filter-card').slideToggle();
                });


                Array.from(document.querySelectorAll('table')).forEach(table => {
                    let heading = table.querySelectorAll('thead tr th');
                    Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                        Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                            colum.setAttribute('data-label', heading[i].innerText)
                        });
                    });
                });


                let disableSubmission = false;
                $('.disableSubmission').on('submit', function(e) {
                    if (disableSubmission) {
                        e.preventDefault()
                    } else {
                        disableSubmission = true;
                    }
                });

            })(jQuery);
        </script>
    </body>
</html>
