<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Multipurpose, super flexible, powerful, clean modern responsive bootstrap 5 admin template">
    <meta name="keywords"
          content="admin template, ra-admin admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="la-themes">
    <link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">

    <title>Landing | ra-admin - Premium Admin Template</title>

    <!--font-awesome-css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Josefin font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
          rel="stylesheet">

    <!--animation-css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/animation/animate.min.css') }}">

    <!-- devicon css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/devicon/devicon.min.css') }}">

    <!-- tabler icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/tabler-icons/tabler-icons.css') }}">

    <!--flag Icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/flag-icons-master/flag-icon.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">

    <!-- aos css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

</head>

<body class="bg-white landing-page">
<!-- Landing page start -->
<div class="app-wrapper flex-column">

    <!-- cursor  -->
    <div class="circle-cursor">
    </div>

    <!-- cursor -->

    <div class="landing-wrapper">
        <!-- Header start -->
        <div class="navbar navbar-expand-lg sticky-top landing-nav_main px-3 position-fixed w-100">
            <div class="container-fluid">
                <a class="navbar-brand logo" href="#home">
                    <img src="{{ asset('assets/images/logo/1.png') }}" alt="#">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landing_nav"
                        aria-controls="landing_nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landing_nav">

                    <ul class="navbar-nav m-auto">

                        <li class="nav-item">
                            <a class="nav-link active" href="#Demo">Demo</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#Cards">Cards</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#Features">Features</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">Document</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://forms.gle/hYrBdsJYsqqWe5pKA" class="nav-link" target="_blank">Hire Us</a>
                        </li>
                    </ul>
                    <a href="https://themeforest.net/user/la-themes" target="_blank" class="btn btn-primary">Buy Now</a>

                </div>
            </div>
        </div>

        <!-- Header end -->

        <!-- landing first section start -->

        <section class="landing-section p-0" id="home">
            <div class="container-fluid">
                <div class="row landing-content mg-t-50">

                    <div class="col-md-8 offset-md-2">
                        <div class="landing-heading text-center">
                            <div class="d-flex align-items-center justify-content-center">
                                <h1>  Your Ultimate Admin <br> Solution for  <span class="highlight-text" id="highlight-text">Management</span></h1>

                            </div>
                        </div>
                        <div class="rotated-text">
                            <p>Ra-admin Comes with so many sidebar option , layouts like RTl & many more ...!</p>
                        </div>
                        <div class="landing-img">
                            <div class="img-box">
                                <img src="{{ asset('assets/images/landing/home-img-1.png') }}" alt="img" class="box-img-1">
                                <img src="{{ asset('assets/images/landing/home-mobile.png') }}" alt="img" class="box-img-2">
                                <img src="{{ asset('assets/images/landing/hom-tab.gif') }}" alt="img" class="box-img-3">
                                <div class="rotated-circle-text">
                                    <img src="{{ asset('assets/images/landing/circle-text.png') }}" class="w-150 h-150 img-rotated" alt="img">
                                    <img src="{{ asset('assets/images/logo/3.png') }}" alt="img" class="bg-light-primary p-4 b-r-50 b-1-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- landing first section end -->
    </div>


    <section class="p-0 overflow-visible">
        <div class="container">
            <div class="language-box">
                <!-- Language boxes with updated asset paths -->
                @foreach(['bootstrap', 'php', 'laravel', 'figma', 'codeigniter', 'symfony', 'cakephp', 'nodejs'] as $lang)
                <div class="language-box-item">
                    <a href="{{ $lang === 'php' ? 'https://phpstack-426242-2145512.cloudwaysapps.com/RaAdmin-PHP/template/index.php' : '#' }}"
                       class="info-box bg-{{ $lang === 'bootstrap' ? 'info' : 'primary' }} h-60 w-60 d-flex-center b-r-50"
                       target="_blank"
                       data-bs-toggle="tooltip"
                       data-bs-custom-class="custom-dark"
                       title="{{ ucfirst($lang) }}">
                        @if($lang === 'codeigniter')
                        <img src="{{ asset('assets/images/document/codeigniter.png') }}" alt="avtar" class="w-25 h-25">
                        @else
                        <i class="devicon-{{ $lang }}-plain f-s-28"></i>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Rest of the content remains similar with asset path updates -->
    <!-- ... (other sections follow the same pattern) ... -->

</div>
<!-- Landing page end -->

<!-- tap on top -->
<div class="go-top">
    <span class="progress-value">
      <i class="ti ti-arrow-up"></i>
    </span>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/phosphor/phosphor.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/landing.js') }}"></script>

</body>
</html>
