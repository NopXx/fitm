<!-- Header Section starts -->
<header class="header-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <span class="header-toggle me-3">
                    <i class="ph ph-circles-four"></i>
                </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                <ul class="d-flex align-items-center">

                    <li class="header-language">
                        <div id="lang_selector" class="flex-shrink-0 dropdown">
                            <a href="#" class="d-block head-icon ps-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="lang-flag lang-en ">
                                    <span class="flag rounded-circle overflow-hidden">
                                        <i class=""></i>
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu language-dropdown header-card border-0">
                                <li class="lang lang-en selected dropdown-item p-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="US">
                                    <span class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-usa flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">US</span>
                                    </span>
                                </li>
                                <li class="lang lang-pt dropdown-item p-2" title="FR">
                                    <span class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-fra flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">France</span>
                                    </span>
                                </li>
                                <li class="lang lang-es dropdown-item p-2" title="UK">
                                    <span class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-gbr flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">UK</span>
                                    </span>
                                </li>
                                <li class="lang lang-es dropdown-item p-2" title="IT">
                                    <span class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-ita flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">Italy</span>
                                    </span>
                                </li>
                            </ul>
                        </div>

                    </li>

                    <li class="header-dark">
                        <div class="sun-logo head-icon">
                            <i class="ph ph-moon-stars"></i>
                        </div>
                        <div class="moon-logo head-icon">
                            <i class="ph ph-sun-dim"></i>
                        </div>
                    </li>

                    <li class="header-profile">
                        <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas"
                            data-bs-target="#profilecanvasRight" aria-controls="profilecanvasRight">
                            <img src="{{ asset('../assets/images/avtar/woman.jpg') }}" alt="avtar"
                                class="b-r-10 h-35 w-35">
                        </a>

                        <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1"
                            id="profilecanvasRight" aria-labelledby="profilecanvasRight">
                            <div class="offcanvas-body app-scroll">
                                <ul class="">
                                    <li>
                                        <div class="d-flex-center">
                                            <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                                                <img src="{{ asset('../assets/images/avtar/woman.jpg') }}"
                                                    alt="" class="img-fluid b-r-10">
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h6 class="mb-0">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</h6>
                                            <p class="f-s-12 mb-0 text-secondary">{{ Auth::user()->email }}</p>
                                        </div>
                                    </li>

                                    {{-- <li class="app-divider-v dotted py-1"></li>
                                    <li>
                                        <a class="f-w-500" href="{{ route('profile') }}" target="_blank">
                                            <i class="ph-duotone  ph-user-circle pe-1 f-s-20"></i> Profile Details
                                        </a>
                                    </li>
                                    <li>
                                        <a class="f-w-500" href="{{ route('setting') }}" target="_blank">
                                            <i class="ph-duotone  ph-gear pe-1 f-s-20"></i> Settings
                                        </a>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="f-w-500" role="button" href="{{ route('setting') }}"
                                                target="_blank" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ph-duotone  ph-eye-slash pe-1 f-s-20"></i> Hide Settings
                                            </a>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input form-check-primary" type="checkbox"
                                                        id="hideSetting" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="f-w-500" href="#">
                                                <i class="ph-duotone  ph-notification pe-1 f-s-20"></i> Notification
                                            </a>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input form-check-primary" type="checkbox"
                                                        id="basicSwitch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <a class="f-w-500" href="#">
                                                    <i class="ph-duotone  ph-detective pe-1 f-s-20"></i> Incognito
                                                </a>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input form-check-primary" type="checkbox"
                                                        id="incognitoSwitch">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="app-divider-v dotted py-1"></li>
                                    <li>
                                        <a class="f-w-500" href="{{ route('faq') }}" target="_blank">
                                            <i class="ph-duotone  ph-question pe-1 f-s-20"></i> Help
                                        </a>
                                    </li>
                                    <li>
                                        <a class="f-w-500" href="{{ route('pricing') }}" target="_blank">
                                            <i class="ph-duotone  ph-currency-circle-dollar pe-1 f-s-20"></i> Pricing
                                        </a>
                                    </li>
                                    <li>
                                        <a class="mb-0 text-secondary f-w-500" href="{{ route('sign_up') }}"
                                            target="_blank">
                                            <i class="ph-bold  ph-plus pe-1 f-s-20"></i> Add account
                                        </a>
                                    </li> --}}
                                    <li class="app-divider-v dotted py-1"></li>

                                    <li>
                                        <a class="mb-0 text-danger" href="{{ route('logout') }}">
                                            <i class="ph-duotone  ph-sign-out pe-1 f-s-20"></i> Log Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Header Section ends -->
