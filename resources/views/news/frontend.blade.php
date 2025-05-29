@extends('layout.app')
@section('title')
    @lang('translation.news')
@endsection

@section('css')
    @vite(['resources/css/new.css'])
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8 dark:bg-gray-900 transition-colors duration-200">
        <!-- Hero Section for Mobile -->
        <div id="heroSection" class="mobile-optimized">
            <!-- Regular News Hero - visible by default -->
            <div id="regularHero" class="block transition-all duration-500 ease-in-out">
                @if (!empty($importantNews) && count($importantNews) > 0)
                    <div class="mb-4">
                        <!-- Embla Carousel for Regular Important News -->
                        <div class="embla">
                            <div class="embla__viewport">
                                <div class="embla__container">
                                    @foreach ($importantNews as $item)
                                        <div class="embla__slide">
                                            <div
                                                class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-700 dark:to-cyan-700 rounded-lg shadow-md transition-colors duration-200">
                                                <div class="container mx-auto px-4 py-5 sm:py-10">
                                                    <div class="flex flex-col md:flex-row items-center">
                                                        <div class="md:w-1/2 lg:pr-10 text-center md:text-left">
                                                            <h1
                                                                class="text-2xl md:text-4xl font-bold text-white leading-tight mb-2 md:mb-4">
                                                                {{ $item->title }}</h1>
                                                            <p class="text-white/90 text-sm md:text-base mb-3 md:mb-6">
                                                                {{ isset($item->description) ? Str::limit($item->description, 120) : '' }}
                                                            </p>
                                                            <div class="flex justify-center md:justify-start">
                                                                @if (isset($item->url) && $item->url)
                                                                    <a href="{{ $item->url }}" target="_blank"
                                                                        class="inline-flex items-center py-2 px-4 md:py-3 md:px-6 text-sm font-medium text-center text-blue-600 dark:text-blue-500 bg-white dark:bg-gray-800 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 transition-colors duration-200">
                                                                        {{ __('news.visit_link') }}
                                                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor"
                                                                            viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                                                clip-rule="evenodd"></path>
                                                                        </svg>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('news.show', $item->id) }}"
                                                                        class="inline-flex items-center py-2 px-4 md:py-3 md:px-6 text-sm font-medium text-center text-blue-600 dark:text-blue-500 bg-white dark:bg-gray-800 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 transition-colors duration-200">
                                                                        {{ __('news.read_more') }}
                                                                        <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor"
                                                                            viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                                                clip-rule="evenodd"></path>
                                                                        </svg>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="md:w-1/2 mt-4 md:mt-0">
                                                            @if (isset($item->cover_image) && $item->cover_image)
                                                                <img src="{{ asset('storage/' . $item->cover_image) }}"
                                                                    alt="{{ $item->title }}"
                                                                    class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                                            @else
                                                                <img src="{{ asset('assets/images/fitm-logo.png') }}"
                                                                    alt="{{ __('news.default_image') }}"
                                                                    class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="embla__dots"></div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-700 dark:to-cyan-700 rounded-lg shadow-md mb-4 transition-colors duration-200">
                        <div class="container mx-auto px-4 py-5 sm:py-10">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="md:w-1/2 lg:pr-10 text-center md:text-left">
                                    <h1 class="text-2xl md:text-4xl font-bold text-white leading-tight mb-2 md:mb-4">
                                        {{ __('news.latest_updates') }}</h1>
                                    <p class="text-white/90 text-sm md:text-base mb-3 md:mb-6">
                                        {{ __('news.stay_updated') }}
                                    </p>
                                </div>
                                <div class="md:w-1/2 mt-4 md:mt-0">
                                    <img src="{{ asset('assets/images/fitm-logo.png') }}"
                                        alt="{{ __('news.default_image') }}"
                                        class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- FITM News Hero - hidden by default -->
            <div id="fitmHero" class="hidden opacity-0 transition-all duration-500 ease-in-out">
                <div
                    class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-700 dark:to-cyan-700 rounded-lg shadow-md mb-4 transition-colors duration-200">
                    <div class="container mx-auto px-4 py-5 sm:py-10">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="md:w-1/2 lg:pr-10 text-center md:text-left">
                                <h1 class="text-2xl md:text-4xl font-bold text-white leading-tight mb-2 md:mb-4">
                                    {{ isset($featuredNews) ? $featuredNews->title : __('news.fitm_latest_updates') }}</h1>
                                <p class="text-white/90 text-sm md:text-base mb-3 md:mb-6">
                                    {{ isset($featuredNews) && isset($featuredNews->description) ? Str::limit($featuredNews->description, 120) : '' }}
                                </p>
                                <div class="flex justify-center md:justify-start">
                                    @if (isset($featuredNews))
                                        @if ($featuredNews->source === 'fitm' && isset($featuredNews->url))
                                            <a href="{{ $featuredNews->url }}" target="_blank"
                                                class="inline-flex items-center py-2 px-4 md:py-3 md:px-6 text-sm font-medium text-center text-blue-600 dark:text-blue-500 bg-white dark:bg-gray-800 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 transition-colors duration-200">
                                                {{ __('news.read_more') }}
                                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="md:w-1/2 mt-4 md:mt-0">
                                @if (isset($featuredNews->cover))
                                    <img src="{{ asset('storage/' . $featuredNews->cover) }}"
                                        alt="{{ $featuredNews->title }}"
                                        class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                @elseif(isset($featuredNews->cover_image) && $featuredNews->cover_image)
                                    <img src="{{ asset('storage/' . $featuredNews->cover_image) }}"
                                        alt="{{ $featuredNews->title }}"
                                        class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                @else
                                    <img src="{{ asset('assets/images/fitm-logo.png') }}"
                                        alt="{{ __('news.default_image') }}"
                                        class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="newsSearch"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="{{ __('news.search_news') }}" aria-label="{{ __('news.search_news') }}"
                    value="{{ $currentFilters['search'] ?? '' }}">
                <button id="clearSearch"
                    class="absolute right-2.5 bottom-2.5 {{ empty($currentFilters['search']) ? 'hidden' : '' }} bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-700 text-white font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-200">
                    {{ __('news.clear') }}
                </button>
            </div>
        </div>

        <!-- News Tabs Section -->
        <div class="mb-8">
            <div class="border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="newsTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg dark:text-white transition-colors duration-200"
                            id="regular-tab" data-tabs-target="#regular-news" type="button" role="tab"
                            aria-controls="regular-news" aria-selected="true">{{ __('news.news') }}</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 dark:text-gray-400 transition-colors duration-200"
                            id="fitm-tab" data-tabs-target="#fitm-news" type="button" role="tab"
                            aria-controls="fitm-news" aria-selected="false">{{ __('news.fitm_news') }}</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('news.loading') }}</p>
        </div>

        <div id="newsTabContent">
            <!-- Regular News Tab -->
            <div class="hidden p-4 rounded-lg bg-white dark:bg-gray-800 transition-colors duration-200" id="regular-news"
                role="tabpanel" aria-labelledby="regular-tab">
                <!-- Regular News Filter Section -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <h2
                            class="text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0 transition-colors duration-200">
                            {{ __('news.latest_news') }}</h2>

                        <!-- Filter Dropdown -->
                        <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                            <div class="w-full sm:w-auto">
                                <select id="newsTypeFilter"
                                    class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors duration-200">
                                    <option value="">{{ __('news.all_types') }}</option>
                                    @foreach ($newsTypes as $newsType)
                                        <option value="{{ $newsType->id }}"
                                            {{ ($currentFilters['news_type'] ?? '') == $newsType->id ? 'selected' : '' }}>
                                            {{ __('news.news_' . $newsType->id) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full sm:w-auto">
                                <button id="filterReset"
                                    class="w-full sm:w-auto text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-4 py-2.5 transition-colors duration-200">
                                    {{ __('news.reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regular News Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="regularNewsGrid">
                    @include('news.partials.regular-news-cards', ['newsItems' => $regularNews])
                </div>

                <!-- Regular News Pagination -->
                <div class="mt-8" id="regularNewsPagination">
                    {{ $regularNews->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- FITM News Tab -->
            <div class="hidden p-4 rounded-lg bg-white dark:bg-gray-800 transition-colors duration-200" id="fitm-news"
                role="tabpanel" aria-labelledby="fitm-tab">
                <!-- FITM News Filter Section -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <h2
                            class="text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0 transition-colors duration-200">
                            {{ __('news.fitm_news') }}</h2>

                        <!-- Filter Dropdown -->
                        <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                            <div class="w-full sm:w-auto">
                                <select id="issueFilter"
                                    class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors duration-200">
                                    <option value="">{{ __('news.all_issues') }}</option>
                                    @foreach ($issues as $issue)
                                        <option value="{{ $issue }}"
                                            {{ ($currentFilters['issue'] ?? '') == $issue ? 'selected' : '' }}>
                                            {{ $issue }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full sm:w-auto">
                                <button id="fitmFilterReset"
                                    class="w-full sm:w-auto text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-4 py-2.5 transition-colors duration-200">
                                    {{ __('news.reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FITM News Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="fitmNewsGrid">
                    @include('news.partials.fitm-news-cards', ['newsItems' => $fitmNews])
                </div>

                <!-- FITM News Pagination -->
                <div class="mt-8" id="fitmNewsPagination">
                    {{ $fitmNews->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        // Translation strings for JavaScript
        window.translations = {
            loading: @json(__('news.loading')),
            no_news_found: @json(__('news.no_news_found')),
            no_fitm_news_found: @json(__('news.no_fitm_news_found')),
            no_match_criteria: @json(__('news.no_match_criteria')),
            visit_link: @json(__('news.visit_link')),
            read_more: @json(__('news.read_more')),
            news_11: @json(__('news.news_11')),
            news_12: @json(__('news.news_12')),
            news_13: @json(__('news.news_13')),
            news_14: @json(__('news.news_14')),
            news_15: @json(__('news.news_15')),
            news_16: @json(__('news.news_16')),
            news_17: @json(__('news.news_17')),
            news_18: @json(__('news.news_18')),
            news_19: @json(__('news.news_19')),
            news_20: @json(__('news.news_20'))
        };

        // URL helpers
        window.routes = {
            news_show: @json(route('news.show', ':id')),
            storage_url: @json(asset('storage')),
            default_image: @json(asset('assets/images/fitm-logo.png'))
        };

        /**
         * Enhanced News Frontend with Server-side Filtering
         */

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize all components
            App.init();

            // Add CSS directly to document head for guaranteed mobile fixes
            const mobileFixes = document.createElement('style');
            mobileFixes.innerHTML = `
                @media (max-width: 640px) {
                    .news-card, .fitm-news-card {
                        margin-bottom: 16px !important;
                        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
                    }
                    .news-card img, .fitm-news-card img {
                        height: 160px !important;
                        object-fit: contain !important;
                    }
                    .news-card > div, .fitm-news-card > div {
                        padding: 12px !important;
                    }
                    .news-card span.bg-blue-100,
                    .fitm-news-card span.bg-green-100,
                    .news-card span.bg-blue-900,
                    .fitm-news-card span.bg-green-900 {
                        display: inline-block !important;
                        margin-bottom: 6px !important;
                        font-size: 0.7rem !important;
                    }
                    .news-card .date-format, .fitm-news-card .date-format {
                        margin-bottom: 6px !important;
                        display: block !important;
                    }
                    .news-card h5, .fitm-news-card h5 {
                        display: block !important;
                        width: 100% !important;
                        min-height: 24px !important;
                        font-size: 16px !important;
                        font-weight: 600 !important;
                        line-height: 1.3 !important;
                        margin: 8px 0 !important;
                        color: #000 !important;
                        overflow: visible !important;
                        white-space: normal !important;
                        text-overflow: clip !important;
                    }
                    .dark .news-card h5, .dark .fitm-news-card h5 {
                        color: #fff !important;
                    }
                    .news-card p, .fitm-news-card p {
                        font-size: 14px !important;
                        line-height: 1.4 !important;
                        margin: 8px 0 12px 0 !important;
                        display: -webkit-box !important;
                        -webkit-line-clamp: 2 !important;
                        -webkit-box-orient: vertical !important;
                        overflow: hidden !important;
                    }
                    .news-card a.inline-flex, .fitm-news-card a.inline-flex {
                        width: 100% !important;
                        justify-content: center !important;
                        padding: 8px 12px !important;
                        margin-top: 8px !important;
                        font-size: 14px !important;
                    }
                }
            `;
            document.head.appendChild(mobileFixes);

            // Fix for title display issues - force proper display for mobile
            function fixMobileNewsCards() {
                if (window.innerWidth <= 640) {
                    document.querySelectorAll('.news-card h5, .fitm-news-card h5').forEach(title => {
                        title.style.cssText =
                            'display: block !important; width: 100% !important; min-height: 24px !important; font-size: 16px !important; font-weight: 600 !important; line-height: 1.3 !important; margin: 8px 0 !important; color: inherit !important; overflow: visible !important;';
                    });
                }
            }

            fixMobileNewsCards();
            window.addEventListener('resize', fixMobileNewsCards);

            document.querySelectorAll('[data-tabs-target]').forEach(tab => {
                tab.addEventListener('click', () => {
                    setTimeout(fixMobileNewsCards, 300);
                });
            });
        });

        // Main application namespace
        const App = {
            init() {
                this.DateFormatter.init();
                this.Carousel.init();
                this.Tabs.init();
                this.NewsFilters.init();
                this.Search.init();
                this.ResponsiveLayout.init();

                window.addEventListener('resize', this.handleResize.bind(this));
            },

            handleResize() {
                this.ResponsiveLayout.applyMobileStyles();
                this.ResponsiveLayout.optimizeHeroForMobile();
            },

            utils: {
                createElement(tag, attributes = {}, content = '') {
                    const element = document.createElement(tag);
                    Object.entries(attributes).forEach(([key, value]) => {
                        if (key === 'class' || key === 'className') {
                            value.split(' ').forEach(cls => {
                                if (cls) element.classList.add(cls);
                            });
                        } else {
                            element.setAttribute(key, value);
                        }
                    });
                    if (content) {
                        element.innerHTML = content;
                    }
                    return element;
                },

                toggleVisibility(element, isVisible, useOpacity = false) {
                    if (!element) return;
                    if (useOpacity) {
                        element.classList.toggle('opacity-0', !isVisible);
                        if (isVisible) {
                            element.classList.remove('hidden');
                            setTimeout(() => element.classList.remove('opacity-0'), 50);
                        } else {
                            element.classList.add('opacity-0');
                            setTimeout(() => element.classList.add('hidden'), 300);
                        }
                    } else {
                        element.classList.toggle('hidden', !isVisible);
                    }
                },

                showLoading() {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    if (loadingIndicator) {
                        loadingIndicator.classList.remove('hidden');
                    }
                },

                hideLoading() {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    if (loadingIndicator) {
                        loadingIndicator.classList.add('hidden');
                    }
                }
            }
        };

        // Date formatting component
        App.DateFormatter = {
            init() {
                document.querySelectorAll('.date-format').forEach(element => {
                    const dateString = element.getAttribute('data-date');
                    if (dateString) {
                        const formattedDate = moment(dateString.trim()).format('LL');
                        element.textContent = formattedDate;
                    }
                });
            }
        };

        // Enhanced News filters with server-side support
        App.NewsFilters = {
            init() {
                this.setupServerSideFilters();
            },

            setupServerSideFilters() {
                const newsTypeFilter = document.getElementById('newsTypeFilter');
                const issueFilter = document.getElementById('issueFilter');
                const filterReset = document.getElementById('filterReset');
                const fitmFilterReset = document.getElementById('fitmFilterReset');

                // News type filter
                if (newsTypeFilter) {
                    newsTypeFilter.addEventListener('change', () => {
                        this.applyFilters('regular');
                    });
                }

                // Issue filter
                if (issueFilter) {
                    issueFilter.addEventListener('change', () => {
                        this.applyFilters('fitm');
                    });
                }

                // Reset buttons
                if (filterReset) {
                    filterReset.addEventListener('click', () => {
                        newsTypeFilter.value = '';
                        this.applyFilters('regular');
                    });
                }

                if (fitmFilterReset) {
                    fitmFilterReset.addEventListener('click', () => {
                        issueFilter.value = '';
                        this.applyFilters('fitm');
                    });
                }
            },

            applyFilters(type = 'both') {
                App.utils.showLoading();

                const params = new URLSearchParams();

                // Get filter values
                const newsTypeFilter = document.getElementById('newsTypeFilter');
                const issueFilter = document.getElementById('issueFilter');
                const searchInput = document.getElementById('newsSearch');

                if (newsTypeFilter && newsTypeFilter.value) {
                    params.append('news_type', newsTypeFilter.value);
                }

                if (issueFilter && issueFilter.value) {
                    params.append('issue', issueFilter.value);
                }

                if (searchInput && searchInput.value.trim()) {
                    params.append('search', searchInput.value.trim());
                }

                params.append('type', type);

                // Make AJAX request
                fetch(`{{ route('news.index') }}?${params.toString()}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.updateNewsGrids(data.data, type);
                            this.updateUrl(params);
                        }
                    })
                    .catch(error => {
                        console.error('Filter error:', error);
                    })
                    .finally(() => {
                        App.utils.hideLoading();
                        App.DateFormatter.init();
                        setTimeout(() => {
                            App.ResponsiveLayout.applyMobileStyles();
                        }, 100);
                    });
            },

            updateNewsGrids(data, type) {
                if (type === 'regular' || type === 'both') {
                    if (data.regularNews) {
                        this.updateGrid('regularNewsGrid', data.regularNews.data, 'regular');
                        this.updatePagination('regularNewsPagination', data.regularNews.pagination);
                    }
                }

                if (type === 'fitm' || type === 'both') {
                    if (data.fitmNews) {
                        this.updateGrid('fitmNewsGrid', data.fitmNews.data, 'fitm');
                        this.updatePagination('fitmNewsPagination', data.fitmNews.pagination);
                    }
                }
            },

            updateGrid(gridId, newsItems, newsType) {
                const grid = document.getElementById(gridId);
                if (!grid) return;

                if (newsItems.length === 0) {
                    grid.innerHTML = this.getNoResultsHTML(newsType);
                    return;
                }

                let cardsHTML = '';
                newsItems.forEach(item => {
                    cardsHTML += this.generateCardHTML(item, newsType);
                });

                grid.innerHTML = cardsHTML;
            },

            updatePagination(paginationId, paginationData) {
                const paginationContainer = document.getElementById(paginationId);
                if (paginationContainer && paginationData.links) {
                    paginationContainer.innerHTML = paginationData.links;
                }
            },

            updateUrl(params) {
                const newUrl = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
                window.history.pushState({}, '', newUrl);
            },

            generateCardHTML(item, type) {
                const isRegular = type === 'regular';
                const cardClass = isRegular ? 'news-card' : 'fitm-news-card';
                const badgeClass = isRegular ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' :
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200';

                const imageUrl = item.cover_image ?
                    `${window.routes.storage_url}/${item.cover_image}` :
                    window.routes.default_image;

                const linkUrl = item.url && item.url.trim() ?
                    item.url :
                    window.routes.news_show.replace(':id', item.id);

                const linkTarget = item.url && item.url.trim() ? 'target="_blank"' : '';
                const linkText = item.url && item.url.trim() ? window.translations.visit_link : window.translations
                    .read_more;

                let badgeHTML = '';
                if (isRegular && item.new_type) {
                    const newsTypeKey = `news_${item.new_type}`;
                    const newsTypeText = window.translations[newsTypeKey] || `News Type ${item.new_type}`;
                    badgeHTML = `<span class="${badgeClass} text-xs font-semibold px-2.5 py-0.5 rounded transition-colors duration-200">
                        ${newsTypeText}
                    </span>`;
                } else if (!isRegular && item.issue_name) {
                    badgeHTML = `<span class="${badgeClass} text-xs font-semibold mr-2 px-2.5 py-0.5 rounded transition-colors duration-200">
                        ${item.issue_name}
                    </span>`;
                }

                return `
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md overflow-hidden ${cardClass} hover:shadow-lg transition-all duration-200"
                         data-type="${item.new_type || ''}" data-issue="${item.issue_name || ''}">
                        <a href="${linkUrl}" ${linkTarget} class="block overflow-hidden">
                            <img class="rounded-t-lg w-full h-48 object-cover hover:scale-105 transition-transform duration-300"
                                 src="${imageUrl}" alt="${item.title || ''}">
                        </a>
                        <div class="p-5">
                            ${badgeHTML}
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-200 date-format"
                                 data-date="${item.published_date || ''}">
                                ${item.published_date ? moment(item.published_date).format('LL') : ''}
                            </div>
                            <h5 class="mb-2 mt-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors duration-200 line-clamp-2">
                                ${item.title || ''}
                            </h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-300 transition-colors duration-200 line-clamp-3">
                                ${item.description ? item.description.substring(0, 120) + (item.description.length > 120 ? '...' : '') : ''}
                            </p>
                            <a href="${linkUrl}" ${linkTarget}
                               class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                                ${linkText}
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                `;
            },

            getNoResultsHTML(type) {
                const title = type === 'regular' ? window.translations.no_news_found : window.translations
                    .no_fitm_news_found;
                const message = window.translations.no_match_criteria;

                return `
                    <div class="col-span-full text-center py-10">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">${title}</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">${message}</p>
                    </div>
                `;
            }
        };

        // Enhanced Search functionality
        App.Search = {
            init() {
                const searchInput = document.getElementById('newsSearch');
                const clearButton = document.getElementById('clearSearch');

                if (!searchInput || !clearButton) return;

                this.searchInput = searchInput;
                this.clearButton = clearButton;

                let searchTimeout;

                searchInput.addEventListener('input', () => {
                    clearButton.style.display = searchInput.value ? 'block' : 'none';

                    // Debounce search
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.performSearch();
                    }, 500);
                });

                clearButton.addEventListener('click', () => {
                    searchInput.value = '';
                    clearButton.style.display = 'none';
                    this.performSearch();
                    searchInput.focus();
                });

                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        this.performSearch();
                    }
                });

                const tabs = document.querySelectorAll('[data-tabs-target]');
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        setTimeout(() => this.performSearch(), 350);
                    });
                });
            },

            performSearch() {
                if (!this.searchInput) return;

                const activeTabPanel = document.querySelector('#newsTabContent [role="tabpanel"]:not(.hidden)');
                const activeTabId = activeTabPanel ? activeTabPanel.id : 'regular-news';
                const type = activeTabId === 'regular-news' ? 'regular' : 'fitm';

                App.NewsFilters.applyFilters(type);
            }
        };

        // Responsive layout handling
        App.ResponsiveLayout = {
            init() {
                this.applyMobileStyles();
                this.optimizeHeroForMobile();

                document.addEventListener('DOMContentLoaded', () => {
                    this.applyMobileStyles();
                    this.optimizeHeroForMobile();
                });
            },

            applyMobileStyles() {
                const isMobile = window.innerWidth < 640;
                const newsCards = document.querySelectorAll('.news-card, .fitm-news-card');

                newsCards.forEach(card => {
                    if (isMobile) {
                        card.classList.add('mobile-card');
                        card.style.margin = '0 0 16px 0';
                        card.style.width = '100%';
                    } else {
                        card.classList.remove('mobile-card');
                        card.style.removeProperty('margin');
                        card.style.removeProperty('width');
                    }

                    const imageLink = card.querySelector('a');
                    const contentDiv = card.querySelector('div.p-5');
                    const title = card.querySelector('h5');
                    const description = card.querySelector('p');
                    const newsType = card.querySelector('span.bg-blue-100, span.bg-green-100');
                    const dateElement = card.querySelector('.date-format');

                    if (isMobile) {
                        if (contentDiv) {
                            contentDiv.style.padding = '12px';
                        }

                        if (newsType) {
                            newsType.style.display = 'inline-block';
                            newsType.style.marginBottom = '6px';
                        }

                        if (dateElement) {
                            dateElement.style.marginBottom = '6px';
                            dateElement.style.display = 'block';
                        }

                        if (title) {
                            title.style.display = 'block';
                            title.style.width = '100%';
                            title.style.minHeight = '24px';
                            title.style.color = '#000';
                            title.classList.add('dark:text-white');
                            title.style.fontSize = '16px';
                            title.style.fontWeight = '600';
                            title.style.lineHeight = '1.3';
                            title.style.margin = '8px 0';
                            title.classList.remove('line-clamp-2', 'line-clamp-3');
                            title.classList.add('line-clamp-2');
                        }

                        if (description) {
                            description.style.fontSize = '14px';
                            description.style.lineHeight = '1.4';
                            description.style.margin = '8px 0 12px 0';
                            description.classList.remove('line-clamp-3');
                            description.classList.add('line-clamp-2');
                        }

                        const actionLink = contentDiv?.querySelector('a.inline-flex');
                        if (actionLink) {
                            actionLink.style.width = '100%';
                            actionLink.style.justifyContent = 'center';
                            actionLink.style.padding = '8px 12px';
                            actionLink.style.marginTop = '8px';

                            if (contentDiv.lastChild !== actionLink) {
                                contentDiv.appendChild(actionLink);
                            }
                        }
                    } else {
                        if (imageLink && imageLink.querySelector('img')) {
                            imageLink.querySelector('img').style.removeProperty('height');
                        }

                        if (contentDiv) contentDiv.style.removeProperty('padding');
                        if (newsType) {
                            newsType.style.removeProperty('display');
                            newsType.style.removeProperty('margin-bottom');
                        }
                        if (dateElement) {
                            dateElement.style.removeProperty('margin-bottom');
                            dateElement.style.removeProperty('display');
                        }
                        if (title) {
                            title.style.removeProperty('display');
                            title.style.removeProperty('width');
                            title.style.removeProperty('min-height');
                            title.style.removeProperty('color');
                            title.style.removeProperty('font-size');
                            title.style.removeProperty('font-weight');
                            title.style.removeProperty('line-height');
                            title.style.removeProperty('margin');
                            title.classList.remove('line-clamp-1');
                            title.classList.add('line-clamp-2');
                        }
                        if (description) {
                            description.style.removeProperty('font-size');
                            description.style.removeProperty('line-height');
                            description.style.removeProperty('margin');
                            description.classList.remove('line-clamp-2');
                            description.classList.add('line-clamp-3');
                        }

                        const actionLink = contentDiv?.querySelector('a.inline-flex');
                        if (actionLink) {
                            actionLink.style.removeProperty('width');
                            actionLink.style.removeProperty('justify-content');
                            actionLink.style.removeProperty('padding');
                            actionLink.style.removeProperty('margin-top');
                        }
                    }
                });
            },

            optimizeHeroForMobile() {
                const isMobile = window.innerWidth < 768;
                if (!isMobile) return;

                const heroSection = document.getElementById('heroSection');
                if (!heroSection) return;

                const heroCards = heroSection.querySelectorAll('.embla__slide > div, .bg-gradient-to-r');

                heroCards.forEach(card => {
                    const flexContainer = card.querySelector('.flex');
                    if (!flexContainer) return;

                    flexContainer.classList.add('flex-col');

                    const textContainer = card.querySelector('.md\\:w-1\\/2:first-child');
                    const imageContainer = card.querySelector('.md\\:w-1\\/2:last-child');

                    if (textContainer && imageContainer) {
                        const title = textContainer.querySelector('h1');
                        const description = textContainer.querySelector('p');

                        if (title && !title.classList.contains('text-center')) {
                            title.classList.add('text-center', 'md:text-left');
                        }

                        if (description && !description.classList.contains('text-center')) {
                            description.classList.add('text-center', 'md:text-left');
                        }

                        const button = textContainer.querySelector('a.inline-flex');
                        if (button) {
                            if (button.parentNode === textContainer) {
                                const buttonWrapper = App.utils.createElement('div', {
                                    class: 'flex justify-center md:justify-start w-full'
                                });
                                textContainer.insertBefore(buttonWrapper, button);
                                buttonWrapper.appendChild(button);
                            } else if (!button.parentElement.classList.contains('justify-center')) {
                                button.parentElement.classList.add('justify-center', 'md:justify-start');
                            }
                        }

                        imageContainer.classList.add('mt-3', 'md:mt-0');
                    }
                });
            }
        };

        // Carousel functionality
        App.Carousel = {
            init() {
                const emblaNode = document.querySelector('.embla');
                if (!emblaNode) return;

                if (typeof EmblaCarousel === 'undefined') {
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/embla-carousel/embla-carousel.umd.js';
                    script.onload = () => this.setupCarousel(emblaNode);
                    document.head.appendChild(script);
                } else {
                    this.setupCarousel(emblaNode);
                }
            },

            setupCarousel(emblaNode) {
                const viewportNode = emblaNode.querySelector('.embla__viewport');
                const dotsNode = emblaNode.querySelector('.embla__dots');
                if (!viewportNode) return;

                const options = {
                    loop: true,
                    align: 'center',
                    draggable: true,
                    dragFree: window.innerWidth < 768,
                    containScroll: window.innerWidth < 768 ? 'trimSnaps' : false
                };

                const embla = EmblaCarousel(viewportNode, options);

                if (dotsNode) {
                    this.setupDots(embla, dotsNode);
                }

                this.setupAutoplay(embla, emblaNode);
            },

            setupDots(embla, dotsNode) {
                const dotsArray = this.createDots(dotsNode, embla);

                dotsArray.forEach((dotNode, i) => {
                    dotNode.addEventListener('click', () => {
                        embla.scrollTo(i);
                    });
                });

                embla.on('select', () => {
                    this.selectDotBtn(dotsArray, embla);
                });

                this.selectDotBtn(dotsArray, embla);
            },

            createDots(dotsNode, emblaApi) {
                const slideCount = emblaApi.slideNodes().length;
                const dotHtml = Array.from({
                        length: slideCount
                    }, () =>
                    '<button class="embla__dot" type="button"></button>'
                ).join('');

                dotsNode.innerHTML = dotHtml;
                return Array.from(dotsNode.querySelectorAll('.embla__dot'));
            },

            selectDotBtn(dotsArray, emblaApi) {
                const currentSlideIndex = emblaApi.selectedScrollSnap();
                dotsArray.forEach((dotNode, i) => {
                    dotNode.classList.toggle('embla__dot--selected', i === currentSlideIndex);
                });
            },

            setupAutoplay(embla, emblaNode) {
                let autoplayInterval = null;
                const autoplayDelay = 5000;

                const stopAutoplay = () => {
                    if (autoplayInterval) {
                        clearInterval(autoplayInterval);
                        autoplayInterval = null;
                    }
                };

                const startAutoplay = () => {
                    stopAutoplay();
                    autoplayInterval = setInterval(() => {
                        if (embla.canScrollNext()) {
                            embla.scrollNext();
                        } else {
                            embla.scrollTo(0);
                        }
                    }, autoplayDelay);
                };

                startAutoplay();

                emblaNode.addEventListener('mouseenter', stopAutoplay);
                emblaNode.addEventListener('touchstart', stopAutoplay, {
                    passive: true
                });
                emblaNode.addEventListener('mouseleave', startAutoplay);
                emblaNode.addEventListener('touchend', startAutoplay);

                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        stopAutoplay();
                    } else {
                        startAutoplay();
                    }
                });

                window.addEventListener('beforeunload', stopAutoplay);
            }
        };

        // Tabs functionality
        App.Tabs = {
            init() {
                const tabs = document.querySelectorAll('[data-tabs-target]');
                const tabContents = document.querySelectorAll('[role="tabpanel"]');

                if (!tabs.length || !tabContents.length) return;

                this.activateTab(tabs[0]);

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => this.handleTabClick(tab, tabs, tabContents));
                });
            },

            activateTab(tab) {
                tab.classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                tab.classList.remove('border-transparent');
                tab.setAttribute('aria-selected', 'true');

                const targetContentId = tab.dataset.tabsTarget;
                const targetContent = document.querySelector(targetContentId);
                if (targetContent) {
                    App.utils.toggleVisibility(targetContent, true);
                }
            },

            deactivateTab(tab) {
                tab.classList.remove('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                tab.classList.add('border-transparent');
                tab.setAttribute('aria-selected', 'false');

                const targetContentId = tab.dataset.tabsTarget;
                const targetContent = document.querySelector(targetContentId);
                if (targetContent) {
                    App.utils.toggleVisibility(targetContent, false);
                }
            },

            handleTabClick(clickedTab, allTabs, allContents) {
                allTabs.forEach(tab => this.deactivateTab(tab));
                this.activateTab(clickedTab);
                this.toggleHeroSections(clickedTab.id);
            },

            toggleHeroSections(tabId) {
                const regularHero = document.getElementById('regularHero');
                const fitmHero = document.getElementById('fitmHero');

                if (!regularHero || !fitmHero) return;

                if (tabId === 'fitm-tab') {
                    App.utils.toggleVisibility(regularHero, false, true);
                    App.utils.toggleVisibility(fitmHero, true, true);
                } else {
                    App.utils.toggleVisibility(fitmHero, false, true);
                    App.utils.toggleVisibility(regularHero, true, true);
                }

                setTimeout(() => App.ResponsiveLayout.optimizeHeroForMobile(), 350);
            }
        };
    </script>
@endsection
