@extends('layout.app')

@section('css')
    @vite(['resources/css/carousel.css'])
@endsection

@section('content')
    <!-- Fixed Header Carousel Structure -->
    <div id="news-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-40 md:h-96 overflow-hidden">
            @foreach ($news_show as $index => $item)
                <div class="hidden transition-transform duration-300 ease-in-out"
                    data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                    <a href="{{ $item->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                        <!-- Fixed image container with proper aspect ratio -->
                        <div class="absolute inset-0">
                            <img src="{{ asset('storage/' . $item->cover) }}" class="w-full h-full object-cover"
                                style="aspect-ratio: 1200/600;" alt="{{ $item->title }}">
                        </div>
                        <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-2 md:p-4">
                            <h2 class="text-base md:text-xl font-bold truncate">{{ Str::limit($item->title, 50) }}</h2>
                            <p class="hidden md:block mt-1 md:mt-2 text-sm md:text-base line-clamp-2">
                                {{ Str::limit($item->detail, 80) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 space-x-2 md:space-x-3 rtl:space-x-reverse bottom-2 left-1/2">
            @foreach ($news_show as $index => $item)
                <button type="button"
                    class="w-2 h-2 md:w-3 md:h-3 rounded-full {{ $loop->first ? 'bg-white' : 'bg-white/50' }}"
                    aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $loop->iteration }}"
                    data-carousel-slide-to="{{ $loop->index }}">
                </button>
            @endforeach
        </div>

        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-1 md:px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-7 h-7 md:w-10 md:h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-2 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-3 h-3 md:w-4 md:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-1 md:px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-7 h-7 md:w-10 md:h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-2 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-3 h-3 md:w-4 md:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <!-- News section -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 dark:bg-gray-900">
        <!-- Important News Section -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold dark:text-white">{{ __('news.important_news') }}</h2>
                <a href="/news"
                    class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    @lang('news.view_all')
                    <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </a>
            </div>

            <!-- Mobile carousel (visible only on mobile) -->
            <section class="embla block md:hidden" id="news-carousel-important">
                <div class="embla__viewport">
                    <div class="embla__container">
                        @foreach ($important_news as $item)
                            <div class="embla__slide">
                                <x-news-card :item="$item" :is-mobile="true" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="embla__controls">
                    <div class="embla__buttons">
                        <button class="embla__button embla__button--prev" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                </path>
                            </svg>
                        </button>

                        <button class="embla__button embla__button--next" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="embla__dots"></div>
                </div>
            </section>

            <!-- Desktop carousel (hidden on mobile) -->
            <section class="embla hidden md:block" id="news-desktop-carousel-important">
                <div class="embla__viewport">
                    <div class="embla__container">
                        @foreach ($important_news as $item)
                            <div class="embla__slide">
                                <x-news-card :item="$item" :is-mobile="false" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="embla__controls">
                    <div class="embla__buttons">
                        <button class="embla__button embla__button--prev" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                </path>
                            </svg>
                        </button>

                        <button class="embla__button embla__button--next" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="embla__dots"></div>
                </div>
            </section>
        </div>
        <!-- News Sections using the component -->
        <x-news-section title="{{ __('news.news') }}" :news="$news" :type-id="11" link="/news" />
        <x-news-section title="{{ __('news.academic_news') }}" :news="$news" :type-id="14" link="/news" />
        <x-news-section title="{{ __('news.research_funding_news') }}" :news="$news" :type-id="12"
            link="/news" />
        <x-news-section title="{{ __('news.procurement_news') }}" :news="$news" :type-id="13" link="news" />
    </div>
    <!-- End of News section -->

    {{-- Calendar and FITM News --}}
    <div class="max-w-screen-xl mx-auto px-2 py-4 dark:bg-gray-900">
        <!-- Main container -->
        <div class="grid grid-cols-1 gap-8">
            <!-- Calendar Section -->
            <div>
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold dark:text-white">{{ __('news.calendar') }}</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <iframe class="w-full h-96 aspect-video"
                        src="https://calendar.google.com/calendar/embed?src=fitm.kmutnb.ac.th_2a21l4ktafu49p7104gip1939k%40group.calendar.google.com&ctz=Asia%2FBangkok"></iframe>
                </div>
            </div>

            <!-- FITM News Section with Desktop Carousel (Embla Version) -->

            <!-- FITM News Desktop Carousel with Embla structure -->
            <section class="embla hidden md:block" id="fitm-news-desktop-carousel">
                <div class="flex justify-between items-center mb-6 mt-6">
                    <h2 class="text-xl font-bold dark:text-white">FITM News</h2>
                    <a href="{{ route('news.index') }}"
                        class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        @lang('news.view_all')
                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>
                <div class="embla__viewport">
                    <div class="embla__container">
                        @foreach ($fitmnews as $item)
                            <div class="embla__slide">
                                <x-fitm-news-card :item="$item" :is-mobile="false" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="embla__controls">
                    <div class="embla__buttons">
                        <button class="embla__button embla__button--prev" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                </path>
                            </svg>
                        </button>

                        <button class="embla__button embla__button--next" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="embla__dots"></div>
                </div>
            </section>

            <!-- FITM News Mobile Carousel with Embla structure -->
            <section class="embla block md:hidden" id="fitm-news-carousel">
                <div class="flex justify-between items-center mb-6 mt-6">
                    <h2 class="text-xl font-bold dark:text-white">FITM News</h2>
                    <a href="{{ route('news.index') }}"
                        class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        @lang('news.view_all')
                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>
                <div class="embla__viewport">
                    <div class="embla__container">
                        @foreach ($fitmnews as $item)
                            <div class="embla__slide">
                                <x-fitm-news-card :item="$item" :is-mobile="true" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="embla__controls">
                    <div class="embla__buttons">
                        <button class="embla__button embla__button--prev" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                </path>
                            </svg>
                        </button>

                        <button class="embla__button embla__button--next" type="button">
                            <svg class="embla__button__svg" viewBox="0 0 532 532">
                                <path fill="currentColor"
                                    d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="embla__dots"></div>
                </div>
            </section>

            <!-- FITM Videos Section with Embla Carousel -->
            <div class="mb-10">
                <div class="flex justify-between items-center mb-6 mt-6">
                    <h2 class="text-xl font-bold dark:text-white">FITM Videos</h2>
                    <a href="https://www.youtube.com/@FITMChannel" target="_blank"
                        class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        @lang('news.all_video')
                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>

                <!-- Desktop carousel (hidden on mobile) -->
                <section class="embla hidden md:block" id="fitm-videos-desktop-carousel">
                    <div class="embla__viewport">
                        <div class="embla__container">
                            @foreach ($videos as $video)
                                <div class="embla__slide">
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 h-full">
                                        <div class="aspect-video">
                                            <iframe class="w-full h-full" src="{{ $video->url }}" frameborder="0"
                                                allowfullscreen></iframe>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-bold text-lg dark:text-white truncate">{{ $video->name }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="embla__controls">
                        <div class="embla__buttons">
                            <button class="embla__button embla__button--prev" type="button">
                                <svg class="embla__button__svg" viewBox="0 0 532 532">
                                    <path fill="currentColor"
                                        d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                    </path>
                                </svg>
                            </button>

                            <button class="embla__button embla__button--next" type="button">
                                <svg class="embla__button__svg" viewBox="0 0 532 532">
                                    <path fill="currentColor"
                                        d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="embla__dots"></div>
                    </div>
                </section>

                <!-- Mobile carousel (visible only on mobile) -->
                <section class="embla block md:hidden" id="fitm-videos-carousel">
                    <div class="embla__viewport">
                        <div class="embla__container">
                            @foreach ($videos as $video)
                                <div class="embla__slide">
                                    <div
                                        class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden h-full hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="aspect-video">
                                            <iframe class="w-full h-full" src="{{ $video->url }}" frameborder="0"
                                                allowfullscreen></iframe>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-bold text-lg dark:text-white truncate">{{ $video->name }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="embla__controls">
                        <div class="embla__buttons">
                            <button class="embla__button embla__button--prev" type="button">
                                <svg class="embla__button__svg" viewBox="0 0 532 532">
                                    <path fill="currentColor"
                                        d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454a35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                                    </path>
                                </svg>
                            </button>

                            <button class="embla__button embla__button--next" type="button">
                                <svg class="embla__button__svg" viewBox="0 0 532 532">
                                    <path fill="currentColor"
                                        d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="embla__dots"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Online Services Section -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 dark:bg-gray-900">
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold dark:text-white">{{ __('news.online_services') }}</h2>
            </div>
        </div>

        <div class="md:grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $service)
                <a href="{{ $service->link }}"
                    class="mb-4 md:mb-0 flex flex-col items-center p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center">
                    @if ($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title_th }}"
                            class="w-20 h-20 mb-3">
                    @else
                        <div class="w-20 h-20 flex items-center justify-center bg-blue-500 rounded-full mb-3">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ app()->getLocale() == 'th' ? $service->title_th : $service->title_en }}
                    </h3>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('script-app')
    <!-- Embla Carousel CDN -->
    <script src="https://unpkg.com/embla-carousel-autoplay/embla-carousel-autoplay.umd.js"></script>
    <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
    <script src="{{ asset('assets/js/carousel.js') }}"></script>
@endsection
