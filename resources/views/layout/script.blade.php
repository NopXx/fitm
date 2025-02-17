<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

<!-- Simple bar js-->
<script src="{{ asset('assets/vendor/simplebar/simplebar.js') }}"></script>

<!-- phosphor js -->
<script src="{{ asset('assets/vendor/phosphor/phosphor.js') }}"></script>

<!-- Customizer js-->
<script src="{{ asset('assets/js/customizer.js') }}"></script>

<!-- prism js-->
<script src="{{ asset('assets/vendor/prism/prism.min.js') }}"></script>

{{-- moment js --}}
<script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>
<!-- Moment.js locales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/th.min.js"></script>

<!-- App js-->
<script src="{{ asset('assets/js/script.js') }}"></script>

@php
    $lang = session()->get('lang') == null ? 'th' : session()->get('lang');
@endphp
<script>
    moment.locale('{{ $lang }}');
</script>

@yield('script')
