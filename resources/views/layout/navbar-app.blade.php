<nav class="bg-primary-light dark:bg-gray-900 sticky top-0 z-50" x-data="{ mobileMenuOpen: false, activeDropdown: null, scrolled: false, searchOpen: false }"
    @keydown.escape="mobileMenuOpen = false; activeDropdown = null; searchOpen = false" x-cloak x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 0 })">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 transition-all duration-300"
        :class="{ 'py-2': scrolled, 'py-4': !scrolled }">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('assets/images/fitm-logo-2.png') }}" :class="{ 'h-10': scrolled, 'h-14': !scrolled }"
                class="transition-all duration-300" alt="FITM Logo" />
        </a>

        <!-- Desktop Menu Dropdown -->
        <div class="hidden w-full md:block md:w-auto">
            <ul class="flex space-x-8">
                @foreach ($menus as $menu)
                    @php
                        $translation = $menu->translations->firstWhere('language_code', App::getLocale());
                        $hasChildren = $menu->children->isNotEmpty();
                        $showDropdown = optional($menu->displaySetting)->show_dropdown;
                        $isVisible = optional($menu->displaySetting)->is_visible;
                    @endphp

                    @if ($isVisible)
                        <li class="relative group">
                            <a href="{{ $translation?->url ?? '#' }}"
                                @mouseenter="activeDropdown = '{{ $menu->id }}'"
                                class="text-white hover:text-gray-100 dark:text-gray-200 dark:hover:text-white flex items-center {{ $menu->displaySetting?->css_class }}">
                                {{ $translation?->name }}
                                @if ($hasChildren && $showDropdown)
                                    <svg class="w-4 h-4 ml-1"
                                        :class="{ 'transform rotate-180': activeDropdown === '{{ $menu->id }}' }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                @endif
                            </a>

                            @if ($hasChildren && $showDropdown)
                                <div x-show="activeDropdown === '{{ $menu->id }}'"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    @mouseleave="activeDropdown = null"
                                    class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50">
                                    @foreach ($menu->children->where('is_active', true)->sortBy('sort_order') as $child)
                                        @php
                                            $childTranslation = $child->translations->firstWhere(
                                                'language_code',
                                                App::getLocale(),
                                            );
                                        @endphp
                                        <a href="{{ $childTranslation?->url ?? '#' }}"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $child->displaySetting?->css_class }}">
                                            {{ $childTranslation?->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        {{-- Theme, Search and Language Controls --}}
        <div class="flex items-center gap-4">
            <!-- Search Button (Desktop & Mobile) -->
            <button @click="searchOpen = !searchOpen" class="text-white dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg text-sm p-2.5" aria-label="เปิดการค้นหา">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            <!-- Theme Toggle Button -->
            <button id="theme-toggle" type="button"
                class="text-white dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-600 rounded-lg text-sm p-2.5">
                <!-- Dark mode icon -->
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <!-- Light mode icon -->
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>

            {{-- Language Switcher --}}
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('changeLang', 'th') }}"
                    class="text-white dark:text-gray-200 text-sm font-medium {{ App::getLocale() === 'th' ? 'underline' : '' }}">ไทย</a>
                <span class="text-white dark:text-gray-200">|</span>
                <a href="{{ route('changeLang', 'en') }}"
                    class="text-white dark:text-gray-200 text-sm font-medium {{ App::getLocale() === 'en' ? 'underline' : '' }}">Eng</a>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white dark:text-gray-200 p-2 z-50"
                :aria-expanded="mobileMenuOpen" aria-label="Toggle menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Search Panel --}}
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-10"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-10"
        @click.away="searchOpen = false"
        class="absolute inset-x-0 top-full bg-white dark:bg-gray-800 shadow-lg py-4 px-6 md:px-8 z-40">
        <form action="{{ route('search') }}" method="GET" class="max-w-screen-xl mx-auto">
            <div class="relative">
                <label for="search-input" class="sr-only">ค้นหา</label>
                <input id="search-input" name="q" type="text"
                       class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                       placeholder="ค้นหาในเว็บไซต์..."
                       @keydown.escape="searchOpen = false"
                       required>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                    ค้นหา <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Mobile Menu Panel --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-x-full"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform -translate-x-full" @click.away="mobileMenuOpen = false"
        class="fixed inset-0 z-40 bg-gray-900 bg-opacity-95 dark:bg-gray-900 dark:bg-opacity-95 md:hidden overflow-y-auto">

        <div class="min-h-screen px-4 py-4 space-y-4">
            {{-- Mobile Language Switcher --}}
            <div class="flex justify-center items-center gap-4 py-4 border-b border-gray-700 dark:border-gray-600">
                <a href="{{ route('changeLang', 'th') }}" @click="mobileMenuOpen = false"
                    class="text-white dark:text-gray-200 text-lg {{ App::getLocale() === 'th' ? 'underline' : '' }}">ไทย</a>
                <span class="text-white dark:text-gray-200">|</span>
                <a href="{{ route('changeLang', 'en') }}" @click="mobileMenuOpen = false"
                    class="text-white dark:text-gray-200 text-lg {{ App::getLocale() === 'en' ? 'underline' : '' }}">Eng</a>
            </div>

            <!-- Mobile Menu Items -->
            <div class="space-y-2">
                @foreach ($menus as $menu)
                    @php
                        $translation = $menu->translations->where('language_code', App::getLocale())->first();
                        $hasChildren = $menu->children->isNotEmpty();
                        $isVisible = optional($menu->displaySetting)->is_visible;
                    @endphp

                    @if ($isVisible)
                        <div x-data="{ open: false }">
                            <div class="flex w-full">
                                <a href="{{ $translation?->url ?? '#' }}" class="grow text-white dark:text-gray-200 py-3 text-xl">
                                    {{ $translation?->name }}
                                </a>
                                @if ($hasChildren)
                                    <button @click="open = !open"
                                        class="flex items-center justify-center text-white dark:text-gray-200 py-3 px-2">
                                        <svg class="w-5 h-5 transform transition-transform duration-200"
                                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            @if ($hasChildren)
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="pl-4 space-y-2 mt-2">
                                    @foreach ($menu->children->sortBy('sort_order') as $child)
                                        @if ($child->is_active)
                                            @php
                                                $childTranslation = $child->translations
                                                    ->where('language_code', App::getLocale())
                                                    ->first();
                                            @endphp
                                            <a href="{{ $childTranslation?->url ?? '#' }}"
                                                @click="mobileMenuOpen = false" class="block text-white dark:text-gray-200 py-2 text-lg">
                                                {{ $childTranslation?->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>