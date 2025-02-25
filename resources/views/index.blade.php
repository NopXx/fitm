@extends('layout.app')
@section('content')
    <div id="news-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-40 md:h-96 overflow-hidden">
        @foreach ($news_show as $index => $item)
            <a href="{{ $item->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $item->cover) }}"
                        class="absolute block w-full h-full object-cover md:object-cover"
                        alt="{{ $item->title }}">
                    <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white p-2 md:p-4">
                        <h2 class="text-base md:text-xl font-bold truncate">{{ Str::limit($item->title, 50) }}</h2>
                        <p class="hidden md:block mt-1 md:mt-2 text-sm md:text-base line-clamp-2">{{ Str::limit($item->detail, 80) }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 space-x-2 md:space-x-3 rtl:space-x-reverse bottom-2 left-1/2">
        @foreach ($news_show as $index => $item)
            <button type="button" class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/50"
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
            <svg class="w-3 h-3 md:w-4 md:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 6 10">
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
            <svg class="w-3 h-3 md:w-4 md:h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

    <!-- News section -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 dark:bg-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold dark:text-white">ข่าวประชาสัมพันธ์</h2>
            <a href="#"
                class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ข่าวทั้งหมด
                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($news as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-200">
                    <a href="{{ $item->link ?? '#' }}" {{ $item->link != '' ? 'target="_blank"' : '' }}>
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700">
                            @if ($item->cover)
                                <img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <img src="{{ asset('assets/images/fitm-logo.png') }}" alt="{{ $item->title }}"
                                    class="w-full h-48 object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-bold text-lg dark:text-white truncate max-w-[70%]">
                                    {{ Str::limit($item->title, 100) }}</h3>
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">{{ $item->created_at->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($item->detail, 100) }}</p>
                            <p
                                class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center">
                                รายละเอียด
                                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mb-6 mt-10">
            <h2 class="text-xl font-bold dark:text-white">ข่าวทุนวิจัย/อบรม</h2>
            <a href="#"
                class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ข่าวทั้งหมด
                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </div>

        <div class="flex justify-between items-center mb-6 mt-10">
            <h2 class="text-xl font-bold dark:text-white">ข่าวจัดซื้อจัดจ้าง</h2>
            <a href="#"
                class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ข่าวทั้งหมด
                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </div>

        <div class="flex justify-between items-center mb-6 mt-10">
            <h2 class="text-xl font-bold dark:text-white">ข่าววิชาการ</h2>
            <a href="#"
                class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                ข่าวทั้งหมด
                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        // Initialize the carousel
        const carousel = new Carousel(document.getElementById('news-carousel'), {
            interval: 3000,
            wrap: false
        });
    </script>
@endsection
