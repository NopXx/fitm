<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- All meta and title start-->
    @include('layout.head')
    <!-- meta and title end-->

    <!-- css start-->
    @include('layout.css')
    <!-- css end-->
</head>

<body>
    <!-- Loader start-->
    <div class="app-wrapper">
        <div class="loader-wrapper">
            <div class="loader_16"></div>
        </div>
        <!-- Loader end-->

        <!-- Menu Navigation start -->
        @include('layout.sidebar-new')
        <!-- Menu Navigation end -->


        <div class="app-content">
            <!-- Header Section start -->
            @include('layout.header-new')
            <!-- Header Section end -->

            <!-- Main Section start -->
            <main>
                {{-- main body content --}}
                @yield('main-content')
            </main>
            <!-- Main Section end -->
        </div>

        <!-- tap on top -->
        <div class="go-top">
            <span class="progress-value">
                <i class="ti ti-arrow-up"></i>
            </span>
        </div>

        <!-- Footer Section start -->
        @include('layout.footer')
        <!-- Footer Section end -->
    </div>
    @include('layout.script')
</body>

<!--customizer-->
{{-- <div id="customizer"></div> --}}

<!-- scripts start-->
<!-- scripts end-->

</html>
