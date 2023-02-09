<!DOCTYPE html>
<html lang="es">
@php
$isIntranet = Route::is('intranet*');
@endphp

<head>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Saeta</title> --}}
    <link href="{{ asset($isIntranet ? 'css/app.css' : 'css/public.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @livewireStyles
    @yield('style')

    @if ($isIntranet)
        <style>
            html {
                font-size: 12.5px;
            }
        </style>
    @endif
</head>

<body>
    <!--
        DO NOT DELETE THIS !!!!!!!!!!
        <div hidden>
        <div class="badge-outline"></div>
        <div class="text-red-500 text-red-800 bg-red-100"></div>
        <div class="text-blue-500 text-blue-800 bg-blue-100"></div>
        <div class="text-green-500 text-green-800 bg-green-100"></div>
        <div class="text-purple-500 text-purple-800 bg-purple-100"></div>
        <div class="text-yellow-500 text-yellow-800 bg-yellow-500"></div>
        <div class="text-blue-500 text-blue-800 bg-blue-100"></div>
        <div class="text-yellow-500 text-yellow-800 bg-yellow-100"></div>
        <div class="text-gray-500 text-gray-800 bg-gray-100"></div>
        <div class="text-gray-500 text-gray-800 bg-gray-100"></div>
    </div> -->
    <div class="fixed w-full h-full bg-gray-200 main-container"
        style="z-index: -1;
            /* background: url('{{ asset('img/default/abstract2.jpg') }}');
            background-size: cover; */
        ">
    </div>
    @includeWhen($isIntranet, 'layouts.section-intranet')
    @includeUnless($isIntranet, 'layouts.section-landing')

    {{-- @if ($isIntranet)
        @include('layouts.section-intranet')
    @else
        @include('layouts.section-landing')
    @endif --}}

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/plugins/mobilefriendly.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAPS_GOOGLE_MAPS_ACCESS_TOKEN') }}&libraries=v=3">
    </script>
    @livewireScripts
    <script src="{{ asset($isIntranet ? 'js/app.intranet.js' : 'js/app.public.js') }}"></script>
    <script>
        window.onload = function() {
            Livewire.hook('message.sent', () => {
                window.dispatchEvent(
                    new CustomEvent('loading', { detail: { loading: true }})
                );
            })
            Livewire.hook('message.processed', (message, component) => {
                window.dispatchEvent(
                    new CustomEvent('loading', { detail: { loading: false }})
                );
            })
        }
    </script>
    @yield('script')
</body>

</html>
