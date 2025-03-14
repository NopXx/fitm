<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- App js-->
{{-- <script src="{{ asset('assets/js/index.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/charts.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/constants.js') }}"></script> --}}
<script src="{{ asset('assets/js/dark-mode.js') }}"></script>
<script src="{{ asset('assets/js/sidebar.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
{{-- moment js --}}
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<!-- Moment.js locales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/th.min.js"></script>

@php
    $lang = session()->get('lang') == null ? 'th' : session()->get('lang');
@endphp
<script>
    moment.locale('{{ $lang }}');
</script>
@yield('script-app')
