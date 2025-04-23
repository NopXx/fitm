<div class="{{ $isMobile ? 'w-full flex-shrink-0 px-1' : 'bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
    <div class="{{ !$isMobile ? '' : 'bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden h-full hover:bg-gray-100 dark:hover:bg-gray-700' }}">
        <a href="{{ $item->url ?? '#' }}" target="_blank">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700">
                @if ($item->cover_image)
                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}"
                         class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('assets/images/fitm-logo.png') }}" alt="{{ $item->title }}"
                         class="w-full h-48 object-cover">
                @endif
            </div>
            <div class="p-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-lg dark:text-white truncate max-w-[70%]">
                        {{ $item->issue_name }}</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($item->published_date)->format('d/m/Y') }}
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                    {{ $item->title }}</p>
                <p class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center">
                    @lang('news.read_more')
                    <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </p>
            </div>
        </a>
    </div>
</div>
