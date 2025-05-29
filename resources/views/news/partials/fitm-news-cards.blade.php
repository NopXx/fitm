@if ($newsItems->isEmpty())
    <div class="col-span-full text-center py-10">
        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 transition-colors duration-200" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white transition-colors duration-200">
            {{ __('news.no_fitm_news_found') }}</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400 transition-colors duration-200">
            {{ __('news.no_match_criteria') }}</p>
    </div>
@endif

@foreach ($newsItems as $item)
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

            <h5 class="mb-2 mt-2 text-gray-600 dark:text-gray-300 text-sm transition-colors duration-200 line-clamp-2">
                {{ $item->title }}
            </h5>

            <p class="mb-3 font-normal text-gray-700 dark:text-gray-300 transition-colors duration-200 line-clamp-3">
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
