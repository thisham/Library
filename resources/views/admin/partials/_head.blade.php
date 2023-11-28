<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/dark.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/rtl.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/customizer.css?v=1.1.0') }}">

<!-- Fullcalender CSS -->
<link rel="stylesheet" href="{{ asset('vendor/flatpickr/dist/flatpickr.min.css') }}">
{{-- <link rel='stylesheet' href="{{asset('vendor/fullcalendar/core/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/daygrid/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/timegrid/main.css')}}" />
<link rel='stylesheet' href="{{asset('vendor/fullcalendar/list/main.css')}}" />
<link rel="stylesheet" href="{{asset('vendor/Leaflet/leaflet.css')}}" /> --}}

<link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />

@if (in_array('select2', $assets ?? []))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css"
        integrity="sha512-aD9ophpFQ61nFZP6hXYu4Q/b/USW7rpLCQLX6Bi0WJHXNO7Js/fUENpBQf/+P4NtpzNX0jSgR5zVvPOJp+W2Kg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endif

<style>
    th.hide-search input {
        display: none;
    }
</style>
