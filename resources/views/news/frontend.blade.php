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
                                        @else
                                            <a href="{{ route('news.show', $featuredNews->id) }}"
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
                    placeholder="{{ __('new.search_news') }}" aria-label="{{ __('new.search_news') }}">
                <button id="clearSearch"
                    class="absolute right-2.5 bottom-2.5 hidden bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-700 text-white font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-200">
                    {{ __('new.clear') }}
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
                                    <option value="11">{{ __('news.news_11') }}</option>
                                    <option value="12">{{ __('news.news_12') }}</option>
                                    <option value="13">{{ __('news.news_13') }}</option>
                                    <option value="14">{{ __('news.news_14') }}</option>
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
                    @if ($regularNews->isEmpty())
                        <div class="col-span-full text-center py-10">
                            <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3
                                class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">
                                {{ __('news.no_news_found') }}</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">
                                {{ __('news.no_match_criteria') }}</p>
                        </div>
                    @endif

                    @foreach ($regularNews as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md overflow-hidden news-card hover:shadow-lg transition-all duration-200"
                            data-type="{{ is_object($item->new_type) ? $item->new_type->id : (is_numeric($item->new_type) ? $item->new_type : '') }}">
                            <a href="{{ isset($item->url) && $item->url ? $item->url : route('news.show', $item->id) }}"
                                {{ isset($item->url) && $item->url ? 'target="_blank"' : '' }}
                                class="block overflow-hidden">
                                <img class="rounded-t-lg w-full h-48 object-cover hover:scale-105 transition-transform duration-300"
                                    src="{{ isset($item->cover) ? asset('storage/' . $item->cover) : (isset($item->cover_image) && $item->cover_image ? asset('storage/' . $item->cover_image) : asset('assets/images/fitm-logo.png')) }}"
                                    alt="{{ $item->title }}">
                            </a>
                            <div class="p-5">
                                @if (isset($item->new_type))
                                    @php
                                        // Get the news type ID
                                        $newTypeId = '';
                                        if (is_object($item->new_type) && isset($item->new_type->id)) {
                                            $newTypeId = $item->new_type->id;
                                        } elseif (is_numeric($item->new_type)) {
                                            $newTypeId = $item->new_type;
                                        }

                                        // Create a translation key based on the news type ID
                                        $translationKey = '';
                                        if ($newTypeId) {
                                            $translationKey = 'news.news_' . $newTypeId;
                                        }
                                    @endphp

                                    @if ($translationKey)
                                        <span
                                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-2.5 py-0.5 rounded transition-colors duration-200">
                                            {{ __($translationKey) }}
                                        </span>
                                    @endif
                                @endif

                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-200 date-format"
                                    data-date="@if ($item->published_date) @if (is_string($item->published_date))
                                                    {{ $item->published_date }}
                                                @else
                                                    {{ $item->published_date->format('Y-m-d') }} @endif
@else
{{ now()->format('Y-m-d') }}
                                              @endif">
                                    <!-- Date will be filled by Moment.js -->
                                </div>

                                <h5
                                    class="mb-2 mt-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors duration-200 line-clamp-2">
                                    {{ $item->title }}
                                </h5>

                                <p
                                    class="mb-3 font-normal text-gray-700 dark:text-gray-300 transition-colors duration-200 line-clamp-3">
                                    {{ Str::limit($item->description ?? '', 120) }}
                                </p>

                                <a href="{{ isset($item->url) && $item->url ? $item->url : route('news.show', $item->id) }}"
                                    {{ isset($item->url) && $item->url ? 'target="_blank"' : '' }}
                                    class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                                    {{ isset($item->url) && $item->url ? __('news.visit_link') : __('news.read_more') }}
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Regular News Pagination -->
                <div class="mt-8">
                    {{ $regularNews->links() }}
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
                                        <option value="{{ $issue }}">{{ $issue }}</option>
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
                    @if ($fitmNews->isEmpty())
                        <div class="col-span-full text-center py-10">
                            <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3
                                class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">
                                {{ __('news.no_fitm_news_found') }}</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">
                                {{ __('news.no_match_criteria') }}</p>
                        </div>
                    @endif

                    @foreach ($fitmNews as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md overflow-hidden fitm-news-card hover:shadow-lg transition-all duration-200"
                            data-issue="{{ is_string($item->issue_name) ? $item->issue_name : '' }}">
                            <a href="{{ $item->url }}" target="_blank" class="block overflow-hidden">
                                <img class="rounded-t-lg w-full h-48 object-cover hover:scale-105 transition-transform duration-300"
                                    src="{{ isset($item->cover) ? asset('storage/' . $item->cover) : (isset($item->cover_image) && $item->cover_image ? asset('storage/' . $item->cover_image) : asset('assets/images/fitm-logo.png')) }}"
                                    alt="{{ $item->title }}">
                            </a>
                            <div class="p-5">
                                @if (isset($item->issue_name))
                                    <span
                                        class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded transition-colors duration-200">{{ $item->issue_name }}</span>
                                @endif

                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-200 date-format"
                                    data-date="@if ($item->published_date) @if (is_string($item->published_date))
                                                    {{ $item->published_date }}
                                                @else
                                                    {{ $item->published_date->format('Y-m-d') }} @endif
@else
{{ now()->format('Y-m-d') }}
                                              @endif">
                                    <!-- Date will be filled by Moment.js -->
                                </div>

                                <h5
                                    class="mb-2 mt-2 text-gray-600 dark:text-gray-300 text-sm transition-colors duration-200 line-clamp-2">
                                    {{ $item->title }}
                                </h5>

                                <p
                                    class="mb-3 font-normal text-gray-700 dark:text-gray-300 transition-colors duration-200 line-clamp-3">
                                    {{ Str::limit($item->description ?? '', 120) }}
                                </p>

                                <a href="{{ $item->url }}" target="_blank"
                                    class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                                    {{ __('news.visit_link') }}
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- FITM News Pagination -->
                <div class="mt-8">
                    {!! $fitmNews->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        /**
         * Main Website Functionality
         * Enhanced and refactored for better performance and maintainability
         */
        console.log({!! json_encode($regularNews) !!});
        window.assetBaseUrl = '{{ asset('') }}';
        window.storageBaseUrl = '{{ asset('storage') }}';
        window.newsShowBaseUrl = '{{ route('news.show', '__ID__') }}';

        // Translations for JavaScript
        window.newsTranslations = {
            'news_11': '{{ __('news.news_11') }}',
            'news_12': '{{ __('news.news_12') }}',
            'news_13': '{{ __('news.news_13') }}',
            'news_14': '{{ __('news.news_14') }}',
            'visit_link': '{{ __('news.visit_link') }}',
            'read_more': '{{ __('news.read_more') }}',
            'loading': '{{ __('news.loading') }}',
            'error_loading': '{{ __('news.error_loading') }}',
            'please_try_again': '{{ __('news.please_try_again') }}',
            'no_news_found': '{{ __('news.no_news_found') }}',
            'no_match_criteria': '{{ __('news.no_match_criteria') }}'
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize all components
            App.init();
            // Add CSS directly to document head for guaranteed mobile fixes
            const mobileFixes = document.createElement('style');
            mobileFixes.innerHTML = `
        @media (max-width: 640px) {
            /* Card container fixes */
            .news-card, .fitm-news-card {
                margin-bottom: 16px !important;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
            }

            /* Image height fixes */
            .news-card img, .fitm-news-card img {
                height: 160px !important;
                object-fit: contain !important;
            }

            /* Content padding */
            .news-card > div, .fitm-news-card > div {
                padding: 12px !important;
            }

            /* Badge styling */
            .news-card span.bg-blue-100,
            .fitm-news-card span.bg-green-100,
            .news-card span.bg-blue-900,
            .fitm-news-card span.bg-green-900 {
                display: inline-block !important;
                margin-bottom: 6px !important;
                font-size: 0.7rem !important;
            }

            /* Date styling */
            .news-card .date-format, .fitm-news-card .date-format {
                margin-bottom: 6px !important;
                display: block !important;
            }

            /* CRITICAL: Title fixes */
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

            /* Dark mode title */
            .dark .news-card h5, .dark .fitm-news-card h5 {
                color: #fff !important;
            }

            /* Description fixes */
            .news-card p, .fitm-news-card p {
                font-size: 14px !important;
                line-height: 1.4 !important;
                margin: 8px 0 12px 0 !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important;
            }

            /* Button styling */
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
                        // Force display properties
                        title.style.cssText =
                            'display: block !important; width: 100% !important; min-height: 24px !important; font-size: 16px !important; font-weight: 600 !important; line-height: 1.3 !important; margin: 8px 0 !important; color: inherit !important; overflow: visible !important;';
                    });
                }
            }

            // Run on page load
            fixMobileNewsCards();

            // Run when window resizes
            window.addEventListener('resize', fixMobileNewsCards);

            // Run after any tab changes
            document.querySelectorAll('[data-tabs-target]').forEach(tab => {
                tab.addEventListener('click', () => {
                    // Small delay to ensure content is visible
                    setTimeout(fixMobileNewsCards, 300);
                });
            });
        });

        // Main application namespace
        const App = {
            init() {
                // Format dates with Moment.js
                this.DateFormatter.init();

                // Initialize UI components
                this.Carousel.init();
                this.Tabs.init();
                this.NewsFilters.init();
                this.Search.init();
                this.ResponsiveLayout.init();

                // Handle window resize events
                window.addEventListener('resize', this.handleResize.bind(this));
            },

            handleResize() {
                this.ResponsiveLayout.applyMobileStyles();
                this.ResponsiveLayout.optimizeHeroForMobile();
            },

            // Utility methods
            utils: {
                // Create element with attributes and content
                createElement(tag, attributes = {}, content = '') {
                    const element = document.createElement(tag);

                    // Set attributes
                    Object.entries(attributes).forEach(([key, value]) => {
                        if (key === 'class' || key === 'className') {
                            value.split(' ').forEach(cls => {
                                if (cls) element.classList.add(cls);
                            });
                        } else {
                            element.setAttribute(key, value);
                        }
                    });

                    // Set content
                    if (content) {
                        element.innerHTML = content;
                    }

                    return element;
                },

                // Toggle visibility of an element
                toggleVisibility(element, isVisible, useOpacity = false) {
                    if (!element) return;

                    if (useOpacity) {
                        element.classList.toggle('opacity-0', !isVisible);

                        if (isVisible) {
                            element.classList.remove('hidden');
                            // Small delay for CSS transition
                            setTimeout(() => element.classList.remove('opacity-0'), 50);
                        } else {
                            element.classList.add('opacity-0');
                            // Wait for opacity transition
                            setTimeout(() => element.classList.add('hidden'), 300);
                        }
                    } else {
                        element.classList.toggle('hidden', !isVisible);
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
                        // Use Moment.js to format the date
                        const formattedDate = moment(dateString.trim()).format('LL');
                        element.textContent = formattedDate;
                    }
                });
            }
        };

        // Responsive layout handling
        App.ResponsiveLayout = {
            init() {
                this.applyMobileStyles();
                this.optimizeHeroForMobile();

                // Apply styles immediately on load
                document.addEventListener('DOMContentLoaded', () => {
                    this.applyMobileStyles();
                    this.optimizeHeroForMobile();
                });
            },

            applyMobileStyles() {
                const isMobile = window.innerWidth < 640;
                const newsCards = document.querySelectorAll('.news-card, .fitm-news-card');

                newsCards.forEach(card => {
                    // Fix basic card styling for mobile
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
                        // Image handling
                        if (imageLink) {
                            const image = imageLink.querySelector('img');
                            // if (image) {
                            //     // Make sure image is not too tall on mobile
                            //     image.style.height = '160px';
                            //     image.classList.add('w-full');
                            // }
                        }

                        // Content div padding adjustment
                        if (contentDiv) {
                            contentDiv.style.padding = '12px';
                        }

                        // News type badge positioning
                        if (newsType) {
                            newsType.style.display = 'inline-block';
                            newsType.style.marginBottom = '6px';
                        }

                        // Date formatting
                        if (dateElement) {
                            dateElement.style.marginBottom = '6px';
                            dateElement.style.display = 'block';
                        }

                        // Title styling - critical fix
                        if (title) {
                            // Force display as block
                            title.style.display = 'block';
                            title.style.width = '100%';
                            // Ensure minimum height to make text visible
                            title.style.minHeight = '24px';
                            // Add contrast and visibility
                            title.style.color = '#000';
                            title.classList.add('dark:text-white');
                            // Font styling
                            title.style.fontSize = '16px';
                            title.style.fontWeight = '600';
                            title.style.lineHeight = '1.3';
                            title.style.margin = '8px 0';
                            // Keep only 2 lines
                            title.classList.remove('line-clamp-2', 'line-clamp-3');
                            title.classList.add('line-clamp-2');
                        }

                        // Description styling
                        if (description) {
                            description.style.fontSize = '14px';
                            description.style.lineHeight = '1.4';
                            description.style.margin = '8px 0 12px 0';
                            description.classList.remove('line-clamp-3');
                            description.classList.add('line-clamp-2');
                        }

                        // Button styling
                        const actionLink = contentDiv?.querySelector('a.inline-flex');
                        if (actionLink) {
                            actionLink.style.width = '100%';
                            actionLink.style.justifyContent = 'center';
                            actionLink.style.padding = '8px 12px';
                            actionLink.style.marginTop = '8px';

                            // Move the button to the bottom of the card
                            if (contentDiv.lastChild !== actionLink) {
                                contentDiv.appendChild(actionLink);
                            }
                        }
                    } else {
                        // Reset all inline styles when on desktop
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
                // Hero section code remains the same...
                const isMobile = window.innerWidth < 768;
                if (!isMobile) return;

                const heroSection = document.getElementById('heroSection');
                if (!heroSection) return;

                // Find all hero cards
                const heroCards = heroSection.querySelectorAll('.embla__slide > div, .bg-gradient-to-r');

                heroCards.forEach(card => {
                    // Get flex container inside the hero
                    const flexContainer = card.querySelector('.flex');
                    if (!flexContainer) return;

                    // Ensure the flex container is set to column on mobile
                    flexContainer.classList.add('flex-col');

                    // Get text container and image container
                    const textContainer = card.querySelector('.md\\:w-1\\/2:first-child');
                    const imageContainer = card.querySelector('.md\\:w-1\\/2:last-child');

                    if (textContainer && imageContainer) {
                        // Center-align text on mobile
                        const title = textContainer.querySelector('h1');
                        const description = textContainer.querySelector('p');

                        if (title && !title.classList.contains('text-center')) {
                            title.classList.add('text-center', 'md:text-left');
                        }

                        if (description && !description.classList.contains('text-center')) {
                            description.classList.add('text-center', 'md:text-left');
                        }

                        // Center the button
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

                        // Adjust spacing for mobile
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

                // Load Embla Carousel from CDN if not loaded
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

                // Adjust options for mobile
                const options = {
                    loop: true,
                    align: 'center',
                    draggable: true,
                    dragFree: window.innerWidth < 768, // Better mobile swiping
                    containScroll: window.innerWidth < 768 ? 'trimSnaps' : false
                };

                const embla = EmblaCarousel(viewportNode, options);

                // Handle dots if they exist
                if (dotsNode) {
                    this.setupDots(embla, dotsNode);
                }

                // Setup autoplay
                this.setupAutoplay(embla, emblaNode);
            },

            setupDots(embla, dotsNode) {
                // Create dots
                const dotsArray = this.createDots(dotsNode, embla);

                // Set up click events
                dotsArray.forEach((dotNode, i) => {
                    dotNode.addEventListener('click', () => {
                        embla.scrollTo(i);
                    });
                });

                // Handle selection changes
                embla.on('select', () => {
                    this.selectDotBtn(dotsArray, embla);
                });

                // Initialize dots
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
                const autoplayDelay = 5000; // 5 seconds between slides

                // Define stopAutoplay first so it can be referenced by startAutoplay
                const stopAutoplay = () => {
                    if (autoplayInterval) {
                        clearInterval(autoplayInterval);
                        autoplayInterval = null;
                    }
                };

                const startAutoplay = () => {
                    stopAutoplay(); // Call the local function directly
                    autoplayInterval = setInterval(() => {
                        if (embla.canScrollNext()) {
                            embla.scrollNext();
                        } else {
                            embla.scrollTo(0);
                        }
                    }, autoplayDelay);
                };

                // Start autoplay
                startAutoplay();

                // Pause/resume autoplay on user interaction
                emblaNode.addEventListener('mouseenter', stopAutoplay);
                emblaNode.addEventListener('touchstart', stopAutoplay, {
                    passive: true
                });
                emblaNode.addEventListener('mouseleave', startAutoplay);
                emblaNode.addEventListener('touchend', startAutoplay);

                // Handle visibility changes
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        stopAutoplay();
                    } else {
                        startAutoplay();
                    }
                });

                // Cleanup
                window.addEventListener('beforeunload', stopAutoplay);
            }
        };

        // Tabs functionality
        App.Tabs = {
            init() {
                const tabs = document.querySelectorAll('[data-tabs-target]');
                const tabContents = document.querySelectorAll('[role="tabpanel"]');

                if (!tabs.length || !tabContents.length) return;

                // Set default active tab (first tab)
                this.activateTab(tabs[0]);

                // Add click event listeners
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => this.handleTabClick(tab, tabs, tabContents));
                });
            },

            activateTab(tab) {
                // Add active classes
                tab.classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                tab.classList.remove('border-transparent');
                tab.setAttribute('aria-selected', 'true');

                // Show related content
                const targetContentId = tab.dataset.tabsTarget;
                const targetContent = document.querySelector(targetContentId);
                if (targetContent) {
                    App.utils.toggleVisibility(targetContent, true);
                }
            },

            deactivateTab(tab) {
                // Remove active classes
                tab.classList.remove('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                tab.classList.add('border-transparent');
                tab.setAttribute('aria-selected', 'false');

                // Hide related content
                const targetContentId = tab.dataset.tabsTarget;
                const targetContent = document.querySelector(targetContentId);
                if (targetContent) {
                    App.utils.toggleVisibility(targetContent, false);
                }
            },

            handleTabClick(clickedTab, allTabs, allContents) {
                // Deactivate all tabs
                allTabs.forEach(tab => this.deactivateTab(tab));

                // Activate clicked tab
                this.activateTab(clickedTab);

                // Toggle hero sections if they exist
                this.toggleHeroSections(clickedTab.id);
            },

            toggleHeroSections(tabId) {
                const regularHero = document.getElementById('regularHero');
                const fitmHero = document.getElementById('fitmHero');

                if (!regularHero || !fitmHero) return;

                if (tabId === 'fitm-tab') {
                    // Show FITM hero, hide regular hero
                    App.utils.toggleVisibility(regularHero, false, true);
                    App.utils.toggleVisibility(fitmHero, true, true);
                } else {
                    // Show regular hero, hide FITM hero
                    App.utils.toggleVisibility(fitmHero, false, true);
                    App.utils.toggleVisibility(regularHero, true, true);
                }

                // Re-apply mobile optimizations after transition
                setTimeout(() => App.ResponsiveLayout.optimizeHeroForMobile(), 350);
            }
        };

        // Updated NewsFilters functionality with AJAX support and proper pagination handling
        App.NewsFilters = {
            currentFilters: {},

            init() {
                // Initialize current filters from URL
                this.currentFilters = this.getFiltersFromURL();

                // Setup filter for regular news with AJAX
                this.setupRegularNewsFilter();

                // Setup filter for FITM news (keeping original client-side filtering)
                this.setupFilter(
                    document.getElementById('issueFilter'),
                    document.getElementById('fitmFilterReset'),
                    '#fitmNewsGrid',
                    '.fitm-news-card',
                    'issue',
                    '{{ __('news.no_fitm_news_found') }}',
                    '{{ __('news.no_match_criteria') }}'
                );

                // Setup pagination link handlers
                this.setupPaginationHandlers();

                // Add debug logging if debug parameter is present
                if (window.location.search.includes('debug=true')) {
                    this.debugFilters();
                }
            },

            getFiltersFromURL() {
                const urlParams = new URLSearchParams(window.location.search);
                return {
                    new_type: urlParams.get('new_type') || '',
                    regular_page: urlParams.get('regular_page') || '1'
                };
            },

            setupRegularNewsFilter() {
                const filterElement = document.getElementById('newsTypeFilter');
                const resetElement = document.getElementById('filterReset');
                const grid = document.querySelector('#regularNewsGrid');

                if (!filterElement || !resetElement || !grid) return;

                // Set initial filter value from URL
                if (this.currentFilters.new_type) {
                    filterElement.value = this.currentFilters.new_type;
                }

                // Function to fetch filtered news from controller
                const fetchFilteredNews = async (newTypeId = '', page = 1) => {
                    try {
                        // Show loading state
                        this.showLoadingState(grid);

                        // Build URL with filter parameters
                        const url = new URL(window.location.origin + window.location.pathname);

                        // Preserve existing parameters and add new ones
                        const currentParams = new URLSearchParams(window.location.search);

                        // Update or remove filter parameters
                        if (newTypeId) {
                            url.searchParams.set('new_type', newTypeId);
                            this.currentFilters.new_type = newTypeId;
                        } else {
                            url.searchParams.delete('new_type');
                            this.currentFilters.new_type = '';
                        }

                        // Handle pagination
                        if (page > 1) {
                            url.searchParams.set('regular_page', page);
                            this.currentFilters.regular_page = page;
                        } else {
                            url.searchParams.delete('regular_page');
                            this.currentFilters.regular_page = '1';
                        }

                        // Preserve other parameters (like fitm_page)
                        if (currentParams.get('fitm_page')) {
                            url.searchParams.set('fitm_page', currentParams.get('fitm_page'));
                        }

                        // Make AJAX request to controller
                        const response = await fetch(url.toString(), {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        // Update the grid with new content
                        this.updateRegularNewsGrid(grid, data.regularNews);

                        // Update pagination if present
                        this.updatePagination(data.pagination);

                        // Update URL without page reload
                        window.history.pushState({}, '', url.toString());

                        // Re-setup pagination handlers for new links
                        this.setupPaginationHandlers();

                    } catch (error) {
                        console.error('Error fetching filtered news:', error);
                        this.showErrorState(grid);
                    }
                };

                // Apply filter when dropdown changes
                filterElement.addEventListener('change', () => {
                    const selectedValue = filterElement.value;
                    // Reset to page 1 when applying new filter
                    fetchFilteredNews(selectedValue, 1);
                });

                // Reset button functionality
                resetElement.addEventListener('click', () => {
                    filterElement.value = '';
                    fetchFilteredNews('', 1);
                });

                // Store reference for pagination use
                this.fetchFilteredNews = fetchFilteredNews;
            },

            setupPaginationHandlers() {
                // Handle pagination clicks for regular news
                document.querySelectorAll('#regular-news .pagination a').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();

                        const url = new URL(link.href);
                        const page = url.searchParams.get('regular_page') || '1';

                        // Use current filter when navigating pages
                        if (this.fetchFilteredNews) {
                            this.fetchFilteredNews(this.currentFilters.new_type, page);
                        }
                    });
                });
            },

            updateRegularNewsGrid(grid, newsData) {
                // Clear existing content
                grid.innerHTML = '';

                if (!newsData || newsData.length === 0) {
                    // Show no results message
                    grid.innerHTML = `
                <div class="col-span-full text-center py-10">
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">
                        ${window.newsTranslations?.no_news_found || 'No news found'}
                    </h3>
                    <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">
                        ${window.newsTranslations?.no_match_criteria || 'No articles match the selected criteria'}
                    </p>
                </div>
            `;
                    return;
                }

                // Generate news cards
                newsData.forEach(item => {
                    const newsCard = this.createNewsCard(item);
                    grid.appendChild(newsCard);
                });

                // Re-apply mobile styles after content update
                setTimeout(() => {
                    App.ResponsiveLayout.applyMobileStyles();
                    // Re-apply date formatting
                    App.DateFormatter.init();
                }, 100);
            },

            createNewsCard(item) {
                // Get translation values from global window object (set by Blade)
                const translations = window.newsTranslations || {};

                // Determine news type translation key
                let newsTypeHtml = '';
                if (item.new_type) {
                    const newTypeId = typeof item.new_type === 'object' ? item.new_type.id : item.new_type;
                    const translationKey = `news_${newTypeId}`;
                    const translatedText = translations[translationKey] || `News Type ${newTypeId}`;
                    newsTypeHtml = `
                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-2.5 py-0.5 rounded transition-colors duration-200">
                    ${translatedText}
                </span>
            `;
                }

                // Determine cover image
                const coverImage = item.cover_image || item.cover || 'assets/images/fitm-logo.png';
                const imageSrc = coverImage.startsWith('assets') ?
                    window.assetBaseUrl + '' + coverImage :
                    window.storageBaseUrl + '/' + coverImage;

                // Determine link URL
                const linkUrl = item.url || window.newsShowBaseUrl.replace('__ID__', item.id);
                const linkTarget = item.url ? 'target="_blank"' : '';
                const linkText = item.url ? (translations.visit_link || 'Visit Link') : (translations.read_more ||
                    'Read More');

                // Format published date
                const publishedDate = item.published_date || new Date().toISOString().split('T')[0];

                const cardHtml = `
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md overflow-hidden news-card hover:shadow-lg transition-all duration-200"
                 data-type="${typeof item.new_type === 'object' ? item.new_type.id : (item.new_type || '')}">
                <a href="${linkUrl}" ${linkTarget} class="block overflow-hidden">
                    <img class="rounded-t-lg w-full h-48 object-cover hover:scale-105 transition-transform duration-300"
                         src="${imageSrc}"
                         alt="${item.title}">
                </a>
                <div class="p-5">
                    ${newsTypeHtml}

                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-200 date-format"
                         data-date="${publishedDate}">
                        <!-- Date will be filled by Moment.js -->
                    </div>

                    <h5 class="mb-2 mt-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors duration-200 line-clamp-2">
                        ${this.escapeHtml(item.title)}
                    </h5>

                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-300 transition-colors duration-200 line-clamp-3">
                        ${this.escapeHtml(item.description || '')}
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

                const cardElement = document.createElement('div');
                cardElement.innerHTML = cardHtml;
                return cardElement.firstElementChild;
            },

            // HTML escape function to prevent XSS
            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            },

            updatePagination(paginationHtml) {
                const paginationContainer = document.querySelector('#regular-news .mt-8');
                if (paginationContainer && paginationHtml) {
                    paginationContainer.innerHTML = paginationHtml;
                    // Re-setup handlers for new pagination links
                    this.setupPaginationHandlers();
                }
            },

            showLoadingState(grid) {
                const loadingText = window.newsTranslations?.loading || 'Loading';
                grid.innerHTML = `
            <div class="col-span-full text-center py-10">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-500 dark:text-gray-400">${loadingText}...</p>
            </div>
        `;
            },

            showErrorState(grid) {
                const errorTitle = window.newsTranslations?.error_loading || 'Error Loading';
                const errorMessage = window.newsTranslations?.please_try_again || 'Please try again';
                grid.innerHTML = `
            <div class="col-span-full text-center py-10">
                <svg class="mx-auto h-16 w-16 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">${errorTitle}</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">${errorMessage}</p>
            </div>
        `;
            },

            // Keep the original setupFilter method for FITM news (client-side filtering)
            setupFilter(filterElement, resetElement, gridSelector, cardSelector, dataAttribute, noResultsTitle,
                noResultsMessage) {
                if (!filterElement || !resetElement) return;

                const grid = document.querySelector(gridSelector);
                if (!grid) return;

                const cards = grid.querySelectorAll(cardSelector);

                const filterCards = () => {
                    const selectedValue = filterElement.value;
                    let visibleCount = 0;

                    cards.forEach(card => {
                        let cardValue = card.getAttribute(`data-${dataAttribute}`);
                        cardValue = cardValue || '';

                        const selectedValueStr = String(selectedValue);
                        const cardValueStr = String(cardValue);

                        if (!selectedValue || cardValueStr === selectedValueStr) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    this.toggleNoResultsMessage(grid, visibleCount, noResultsTitle, noResultsMessage);
                    App.Search.performSearch();
                };

                filterElement.addEventListener('change', filterCards);
                resetElement.addEventListener('click', () => {
                    filterElement.value = '';
                    filterCards();
                });
            },

            toggleNoResultsMessage(grid, visibleCount, title, message) {
                const existingNoResults = grid.querySelector('.no-results');

                if (visibleCount === 0) {
                    if (!existingNoResults) {
                        const noResults = App.utils.createElement('div', {
                            class: 'col-span-full text-center py-10 no-results'
                        }, `
                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">${title}</h3>
                    <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">${message}</p>
                `);
                        grid.appendChild(noResults);
                    }
                } else if (existingNoResults) {
                    existingNoResults.remove();
                }
            },

            debugFilters() {
                console.log("=== Filter Values ===");
                const typeFilter = document.getElementById('newsTypeFilter');
                const issueFilter = document.getElementById('issueFilter');

                if (typeFilter) {
                    console.log("News Type Filter:", {
                        selectedValue: typeFilter.value,
                        options: Array.from(typeFilter.options).map(o => ({
                            value: o.value,
                            text: o.text
                        }))
                    });
                }

                if (issueFilter) {
                    console.log("Issue Filter:", {
                        selectedValue: issueFilter.value,
                        options: Array.from(issueFilter.options).map(o => ({
                            value: o.value,
                            text: o.text
                        }))
                    });
                }
            }
        };

        // Search functionality
        // Search functionality
        App.Search = {
            init() {
                const searchInput = document.getElementById('newsSearch');
                const clearButton = document.getElementById('clearSearch');

                if (!searchInput || !clearButton) return;

                // Save references
                this.searchInput = searchInput;
                this.clearButton = clearButton;

                // Show/hide clear button based on search input
                searchInput.addEventListener('input', () => {
                    clearButton.style.display = searchInput.value ? 'block' : 'none';
                    this.performSearch();
                });

                // Clear search
                clearButton.addEventListener('click', () => {
                    searchInput.value = '';
                    clearButton.style.display = 'none';
                    this.performSearch();
                    searchInput.focus();
                });

                // Search on Enter key
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.performSearch();
                    }
                });

                // Tab switching should re-apply search
                const tabs = document.querySelectorAll('[data-tabs-target]');
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Add small delay to ensure tab content is visible
                        setTimeout(() => this.performSearch(), 350);
                    });
                });
            },

            performSearch() {
                // Skip if search isn't initialized
                if (!this.searchInput) return;

                const searchTerm = this.searchInput.value.toLowerCase().trim();
                const activeTabPanel = document.querySelector('#newsTabContent [role="tabpanel"]:not(.hidden)');
                const activeTabId = activeTabPanel ? activeTabPanel.id : 'regular-news';

                // Determine which cards to search based on active tab
                let cards;
                let grid;
                let noResultsTitle, noResultsMessage;

                if (activeTabId === 'regular-news') {
                    grid = document.getElementById('regularNewsGrid');
                    cards = grid?.querySelectorAll('.news-card');
                    noResultsTitle = '{{ __('news.no_news_found') }}';
                    noResultsMessage = '{{ __('news.no_match_search') }}';
                } else {
                    grid = document.getElementById('fitmNewsGrid');
                    cards = grid?.querySelectorAll('.fitm-news-card');
                    noResultsTitle = '{{ __('news.no_fitm_news_found') }}';
                    noResultsMessage = '{{ __('news.no_match_search') }}';
                }

                // Exit if grid not found
                if (!grid || !cards) return;

                let visibleCount = 0;

                // If no search term, don't change the current visibility state of cards
                if (searchTerm === '') {
                    // Just count visible cards for the "no results" message
                    cards.forEach(card => {
                        if (card.style.display !== 'none') {
                            visibleCount++;
                        }
                    });
                } else {
                    // Apply search filtering
                    cards.forEach(card => {
                        // Only search cards that are not already hidden by other filters
                        if (card.style.display !== 'none') {
                            const title = card.querySelector('h5')?.textContent.toLowerCase() || '';
                            const description = card.querySelector('p')?.textContent.toLowerCase() || '';

                            // Show or hide based on search
                            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                                card.style.display = '';
                                visibleCount++;
                            } else {
                                card.style.display = 'none';
                            }
                        }
                    });
                }

                // Handle "no results" message
                App.NewsFilters.toggleNoResultsMessage(grid, visibleCount, noResultsTitle, noResultsMessage);
            }
        };
    </script>
@endsection
