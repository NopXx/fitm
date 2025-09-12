@props(['newsItems', 'issues', 'currentFilters' => []])

<div class="hidden p-4 rounded-lg bg-white dark:bg-gray-800 transition-colors duration-200" id="fitm-news" role="tabpanel"
    aria-labelledby="fitm-tab">
    <!-- FITM News Filter Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 sm:mb-0 transition-colors duration-200">
                {{ __('news.fitm_news') }}</h2>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch" id="fitmNewsGrid">
        @include('news.partials.news-card', [
            'newsItems' => $newsItems,
            'type' => 'fitm',
            'badgeClass' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            'dataAttribute' => 'issue',
        ])
    </div>

    <!-- FITM News Pagination -->
    <div class="mt-8" id="fitmNewsPagination">
        {{ $newsItems->appends(request()->query())->links() }}
    </div>
</div>
