<div class="mb-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold dark:text-white">{{ $title }}</h2>
        @if ($link && $link != '#')
            <a href="{{ $link }}" class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                @lang('news.view_all')
                <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        @endif
    </div>

    <!-- Mobile carousel (visible only on mobile) -->
    <section class="embla block md:hidden" id="news-carousel-{{ $typeId }}">
        <div class="embla__viewport">
            <div class="embla__container">
                @php $newsFiltered = collect($news)->where('new_type', $typeId); @endphp
                @foreach ($newsFiltered as $item)
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
                        <path
                            fill="currentColor"
                            d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z"
                        ></path>
                    </svg>
                </button>

                <button class="embla__button embla__button--next" type="button">
                    <svg class="embla__button__svg" viewBox="0 0 532 532">
                        <path
                            fill="currentColor"
                            d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z"
                        ></path>
                    </svg>
                </button>
            </div>

            <div class="embla__dots"></div>
        </div>
    </section>

    <!-- Desktop carousel (hidden on mobile) -->
    <section class="embla hidden md:block" id="news-desktop-carousel-{{ $typeId }}">
        <div class="embla__viewport">
            <div class="embla__container">
                @php
                    $newsFiltered = collect($news)->where('new_type', $typeId);
                @endphp

                @foreach ($newsFiltered as $item)
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
                        <path
                            fill="currentColor"
                            d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z"
                        ></path>
                    </svg>
                </button>

                <button class="embla__button embla__button--next" type="button">
                    <svg class="embla__button__svg" viewBox="0 0 532 532">
                        <path
                            fill="currentColor"
                            d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z"
                        ></path>
                    </svg>
                </button>
            </div>

            <div class="embla__dots"></div>
        </div>
    </section>
</div>
