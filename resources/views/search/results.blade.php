@extends('layout.app')
@section('title')
    @lang('search.placeholder')
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">{{ __('search.results_title') }}</h1>

            <form action="{{ route('search') }}" method="GET" class="mb-6">
                <div class="relative">
                    <input type="text" name="q" value="{{ $query }}"
                        class="w-full p-4 pl-10 pr-20 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                        placeholder="{{ __('search.placeholder') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit"
                        class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        {{ __('search.search_button') }}
                    </button>
                </div>
            </form>

            <div class="text-lg text-gray-800 dark:text-gray-200">
                @if ($query)
                    <p>{{ __('search.found_results', ['count' => $totalResults, 'query' => $query]) }}</p>
                @endif
            </div>
        </div>

        @if ($query && $totalResults === 0)
            <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ __('search.no_results') }}</h2>
                <p class="text-gray-600 dark:text-gray-400">{{ __('search.suggestions') }}</p>
            </div>
        @endif

        <!-- News Results -->
        @if ($newsResults->count() > 0)
            <div class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">
                    {{ __('search.news_section') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($newsResults as $news)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if ($news->cover)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $news->cover) }}" alt="{{ $news->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-4">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">{{ $news->effective_date instanceof \Carbon\Carbon ? $news->effective_date->format('d M Y') : $news->effective_date }}</span>
                                <h3 class="font-bold text-lg mb-2 line-clamp-2 text-gray-900 dark:text-white">
                                    {{ $news->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-3">{{ $news->detail }}</p>
                                <a href="{{ $news->link === null ? route('news.show', $news->id) : $news->link }}"
                                    class="inline-block text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('search.read_more') }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- FITM News Results -->
        @if ($fitmNewsResults->count() > 0)
            <div class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">
                    {{ __('search.fitm_news_section') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($fitmNewsResults as $fitmNews)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if ($fitmNews->cover_image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $fitmNews->cover_image) }}"
                                        alt="{{ $fitmNews->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-4">
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">{{ $fitmNews->published_date instanceof \Carbon\Carbon ? $fitmNews->published_date->format('d M Y') : $fitmNews->published_date }}</span>
                                <h3 class="font-bold text-lg mb-2 line-clamp-2 text-gray-900 dark:text-white">
                                    {{ $fitmNews->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-3">{{ $fitmNews->description }}
                                </p>
                                <a href="{{ $fitmNews->url }}"
                                    class="inline-block text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('search.read_more') }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Content Results -->
        @if ($contentResults->count() > 0)
            <div class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">
                    {{ __('search.content_section') }}</h2>
                <div class="space-y-6">
                    @foreach ($contentResults as $content)
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-white">
                                {{ app()->getLocale() === 'th' ? $content->title_th : $content->title_en }}</h3>
                            <a href="{{ url('/contents/' . $content->code) }}"
                                class="inline-block text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('search.read_more') }} &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
