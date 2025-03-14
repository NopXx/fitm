@extends('layout.app')

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
                                    @foreach ($newsTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->new_type_name }}</option>
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
                            data-type="{{ $item->new_type ?? '' }}">
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
                                        $newTypeName = '';
                                        if (is_object($item->new_type) && isset($item->new_type->name)) {
                                            $newTypeName = $item->new_type->name;
                                        } elseif (is_numeric($item->new_type)) {
                                            $newType = \App\Models\NewType::select('new_type_name as name')->find(
                                                $item->new_type,
                                            );
                                            $newTypeName = $newType ? $newType->name : '';
                                        }
                                    @endphp
                                    @if ($newTypeName)
                                        <span
                                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-2.5 py-0.5 rounded transition-colors duration-200">{{ $newTypeName }}</span>
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
                            data-issue="{{ $item->issue_name ?? '' }}">
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
                                    class="mb-2 mt-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors duration-200 line-clamp-2">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Format dates with Moment.js
            document.querySelectorAll('.date-format').forEach(function(element) {
                const dateString = element.getAttribute('data-date');
                if (dateString) {
                    // Use Moment.js to format the date
                    const formattedDate = moment(dateString.trim()).format('LL'); // Localized date format
                    element.textContent = formattedDate;
                }
            });

            // Initialize Embla Carousel if it exists
            initializeCarousel();

            // Apply mobile styles
            applyMobileStyles();
            optimizeHeroForMobile();

            // Set up tabs functionality
            initializeTabs();

            // Set up news filters
            initializeFilters();

            // Handle window resize events for responsive layouts
            window.addEventListener('resize', function() {
                applyMobileStyles();
                optimizeHeroForMobile();
            });
        });

        // CAROUSEL FUNCTIONALITY
        function initializeCarousel() {
            const emblaNode = document.querySelector('.embla');
            if (!emblaNode) return;

            // Load Embla Carousel from CDN if not loaded
            if (typeof EmblaCarousel === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/embla-carousel/embla-carousel.umd.js';
                script.onload = setupCarousel;
                document.head.appendChild(script);
            } else {
                setupCarousel();
            }
        }

        function setupCarousel() {
            const emblaNode = document.querySelector('.embla');
            if (!emblaNode) return;

            const viewportNode = emblaNode.querySelector('.embla__viewport');
            const dotsNode = emblaNode.querySelector('.embla__dots');

            // Adjust options for mobile
            const options = {
                loop: true,
                align: 'center',
                draggable: true,
                dragFree: window.innerWidth < 768, // Better mobile swiping
                containScroll: window.innerWidth < 768 ? 'trimSnaps' : false
            };

            const embla = EmblaCarousel(viewportNode, options);

            // Create dots
            const dotsArray = createDots(dotsNode, embla);
            setupDotBtns(dotsArray, embla);

            embla.on('select', () => {
                selectDotBtn(dotsArray, embla);
            });

            // Initial dot selection
            selectDotBtn(dotsArray, embla);

            // Setup autoplay
            let autoplayInterval = null;
            const autoplayDelay = 5000; // 5 seconds between slides

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

            const stopAutoplay = () => {
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                    autoplayInterval = null;
                }
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

        function createDots(dotsNode, emblaApi) {
            const slideCount = emblaApi.slideNodes().length;
            const dotHtml = Array.from({
                    length: slideCount
                }, () =>
                '<button class="embla__dot" type="button"></button>'
            ).join('');

            dotsNode.innerHTML = dotHtml;
            return Array.from(dotsNode.querySelectorAll('.embla__dot'));
        }

        function setupDotBtns(dotsArray, emblaApi) {
            dotsArray.forEach((dotNode, i) => {
                dotNode.addEventListener('click', () => {
                    emblaApi.scrollTo(i);
                });
            });
        }

        function selectDotBtn(dotsArray, emblaApi) {
            const currentSlideIndex = emblaApi.selectedScrollSnap();
            dotsArray.forEach((dotNode, i) => {
                dotNode.classList.toggle('embla__dot--selected', i === currentSlideIndex);
            });
        }

        // RESPONSIVE LAYOUT FUNCTIONS
        function applyMobileStyles() {
            const isMobile = window.innerWidth < 640;
            const newsCards = document.querySelectorAll('.news-card, .fitm-news-card');

            newsCards.forEach(card => {
                const imageLink = card.querySelector('a');
                const contentDiv = card.querySelector('div');

                if (isMobile) {
                    // Mobile layout adjustments
                    if (card.firstChild !== imageLink) {
                        card.prepend(imageLink);
                    }

                    const title = card.querySelector('h5');
                    if (title) {
                        title.classList.remove('line-clamp-2');
                        title.classList.add('line-clamp-1');
                    }

                    const actionLink = contentDiv.querySelector('a.inline-flex');
                    if (actionLink && contentDiv.lastChild !== actionLink) {
                        contentDiv.appendChild(actionLink);
                    }
                } else {
                    // Desktop layout adjustments
                    const title = card.querySelector('h5');
                    if (title) {
                        title.classList.remove('line-clamp-1');
                        title.classList.add('line-clamp-2');
                    }
                }
            });
        }

        function optimizeHeroForMobile() {
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
                    if (button && !button.parentElement.classList.contains('justify-center')) {
                        // Create wrapper if needed
                        if (button.parentNode === textContainer) {
                            const buttonWrapper = document.createElement('div');
                            buttonWrapper.className = 'flex justify-center md:justify-start w-full';
                            textContainer.insertBefore(buttonWrapper, button);
                            buttonWrapper.appendChild(button);
                        } else if (!button.parentElement.classList.contains('justify-center')) {
                            button.parentElement.classList.add('justify-center', 'md:justify-start');
                        }
                    }

                    // Adjust spacing for mobile
                    if (imageContainer) {
                        imageContainer.classList.add('mt-3', 'md:mt-0');
                    }
                }
            });
        }

        // TABS FUNCTIONALITY
        function initializeTabs() {
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');
            const regularHero = document.getElementById('regularHero');
            const fitmHero = document.getElementById('fitmHero');

            if (!tabs.length || !tabContents.length) return;

            // Set default active tab (first tab)
            tabs[0].classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
            const defaultTabContent = document.querySelector(tabs[0].dataset.tabsTarget);
            if (defaultTabContent) {
                defaultTabContent.classList.remove('hidden');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabs.forEach(t => {
                        t.classList.remove('text-blue-600', 'border-blue-600', 'dark:text-blue-500',
                            'dark:border-blue-500');
                        t.classList.add('border-transparent');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Set active tab
                    tab.classList.remove('border-transparent');
                    tab.classList.add('text-blue-600', 'border-blue-600', 'dark:text-blue-500',
                        'dark:border-blue-500');
                    tab.setAttribute('aria-selected', 'true');

                    // Show active tab content
                    const target = document.querySelector(tab.dataset.tabsTarget);
                    if (target) {
                        target.classList.remove('hidden');
                    }

                    // Toggle the hero section based on the active tab with animation
                    if (tab.id === 'fitm-tab' && regularHero && fitmHero) {
                        // Fade out regular hero
                        regularHero.classList.add('opacity-0');

                        setTimeout(() => {
                            regularHero.classList.add('hidden');
                            fitmHero.classList.remove('hidden');

                            // Small delay before fade-in for smoother transition
                            setTimeout(() => {
                                fitmHero.classList.remove('opacity-0');
                                // Re-apply mobile optimizations to the newly visible hero
                                optimizeHeroForMobile();
                            }, 50);
                        }, 300);
                    } else if (regularHero && fitmHero) {
                        // Fade out fitm hero
                        fitmHero.classList.add('opacity-0');

                        setTimeout(() => {
                            fitmHero.classList.add('hidden');
                            regularHero.classList.remove('hidden');

                            // Small delay before fade-in for smoother transition
                            setTimeout(() => {
                                regularHero.classList.remove('opacity-0');
                                // Re-apply mobile optimizations to the newly visible hero
                                optimizeHeroForMobile();
                            }, 50);
                        }, 300);
                    }
                });
            });
        }

        // NEWS FILTERS
        function initializeFilters() {
            // Setup filter for regular news
            setupFilter(
                document.getElementById('newsTypeFilter'),
                document.getElementById('filterReset'),
                '#regularNewsGrid',
                '.news-card',
                'type',
                '{{ __('news.no_news_found') }}',
                '{{ __('news.no_match_criteria') }}'
            );

            // Setup filter for FITM news
            setupFilter(
                document.getElementById('issueFilter'),
                document.getElementById('fitmFilterReset'),
                '#fitmNewsGrid',
                '.fitm-news-card',
                'issue',
                '{{ __('news.no_fitm_news_found') }}',
                '{{ __('news.no_match_criteria') }}'
            );

            // Debug logs for troubleshooting
            logFilterData();
        }

        function setupFilter(filterElement, resetElement, gridSelector, cardSelector, dataAttribute, noResultsTitle,
            noResultsMessage) {
            if (!filterElement || !resetElement) return;

            const grid = document.querySelector(gridSelector);
            if (!grid) return;

            // All cards in this grid
            const cards = grid.querySelectorAll(cardSelector);

            // Function to filter cards
            const filterCards = () => {
                const selectedValue = filterElement.value;
                console.log(`Filtering ${dataAttribute} by value: "${selectedValue}"`);

                let visibleCount = 0;

                // Process each card
                cards.forEach(card => {
                    // Get the attribute value, normalized to handle null/undefined
                    let cardValue = card.getAttribute(`data-${dataAttribute}`);
                    cardValue = cardValue || '';

                    // Show or hide based on filter
                    if (!selectedValue || cardValue === selectedValue) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Handle "no results" message
                toggleNoResultsMessage(grid, visibleCount, noResultsTitle, noResultsMessage);
            };

            // Apply filter when dropdown changes
            filterElement.addEventListener('change', filterCards);

            // Reset button functionality
            resetElement.addEventListener('click', () => {
                filterElement.value = '';
                filterCards();
            });
        }

        function toggleNoResultsMessage(grid, visibleCount, title, message) {
            // Check for existing no-results element
            const existingNoResults = grid.querySelector('.no-results');

            if (visibleCount === 0) {
                // Show no results message if needed
                if (!existingNoResults) {
                    const noResults = document.createElement('div');
                    noResults.className = 'col-span-full text-center py-10 no-results';
                    noResults.innerHTML = `
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">${title}</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">${message}</p>
                    `;
                    grid.appendChild(noResults);
                }
            } else if (existingNoResults) {
                // Remove no results message if there are visible cards
                existingNoResults.remove();
            }
        }

        function logFilterData() {
            // Log regular news cards data
            console.log("=== Regular News Cards Data Types ===");
            document.querySelectorAll('#regularNewsGrid .news-card').forEach((card, index) => {
                console.log(`Card ${index}:`, {
                    type: card.getAttribute('data-type'),
                    visible: card.style.display !== 'none'
                });
            });

            // Log FITM news cards data
            console.log("=== FITM News Cards Data Issues ===");
            document.querySelectorAll('#fitmNewsGrid .fitm-news-card').forEach((card, index) => {
                console.log(`Card ${index}:`, {
                    issue: card.getAttribute('data-issue'),
                    visible: card.style.display !== 'none'
                });
            });

            // Log filter options
            const typeFilter = document.getElementById('newsTypeFilter');
            const issueFilter = document.getElementById('issueFilter');

            console.log("=== Filter Options ===");
            if (typeFilter) {
                console.log("Type Filter Options:", Array.from(typeFilter.options).map(opt => ({
                    value: opt.value,
                    text: opt.text
                })));
            }

            if (issueFilter) {
                console.log("Issue Filter Options:", Array.from(issueFilter.options).map(opt => ({
                    value: opt.value,
                    text: opt.text
                })));
            }
        }
    </script>
@endsection
