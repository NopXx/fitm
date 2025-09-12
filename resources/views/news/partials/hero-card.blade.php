@props([
    'item' => null,
    'type' => 'regular',
    'defaultTitle' => __('news.latest_updates'),
    'defaultDescription' => __('news.stay_updated'),
    'defaultImage' => asset('assets/images/fitm-logo.png'),
])

<div
    class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-700 dark:to-cyan-700 rounded-lg shadow-md transition-colors duration-200">
    <div class="container mx-auto px-4 py-5 sm:py-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 lg:pr-10 text-center md:text-left">
                <h1 class="text-2xl md:text-4xl font-bold text-white leading-tight mb-2 md:mb-4">
                    {{ $item ? ($type === 'regular' ? $item->title : $item->title_th) : $defaultTitle }}
                </h1>
                <p class="text-white/90 text-sm md:text-base mb-3 md:mb-6">
                    {{ $item && $item->description ? Str::limit($item->description, 120) : $defaultDescription }}
                </p>
                <div class="flex justify-center md:justify-start">
                    @if ($item && $item->url)
                        <a href="{{ $item->url }}" target="_blank"
                            class="inline-flex items-center py-2 px-4 md:py-3 md:px-6 text-sm font-medium text-center text-blue-600 dark:text-blue-500 bg-white dark:bg-gray-800 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 transition-colors duration-200">
                            {{ __('news.' . ($type === 'regular' ? 'visit_link' : 'read_more')) }}
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @elseif ($item)
                        <a href="{{ route('news.show', $item->id) }}"
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
                </div>
            </div>
            <div class="md:w-1/2 mt-4 md:mt-0">
                <img src="{{ $item && ($item->cover ?? $item->cover_image) ? asset('storage/' . ($item->cover ?? $item->cover_image)) : $defaultImage }}"
                    alt="{{ $item ? ($type === 'regular' ? $item->title : $item->title_th) : __('news.default_image') }}"
                    class="rounded-lg shadow-md object-cover w-full h-36 md:h-64">
            </div>
        </div>
    </div>
</div>
