@props(['menus', 'currentLang' => 'th'])

<nav class="bg-primary-light">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        {{-- Logo --}}
        <a href="#" class="flex items-center">
            <img src="{{ asset('assets/images/fitm-logo-2.png') }}" class="h-14" alt="FITM Logo" />
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden w-full md:block md:w-auto">
            <ul class="flex space-x-8">
                @foreach($menus as $menu)
                    @php
                        $translation = $menu->translations->where('language_code', $currentLang)->first();
                        $hasChildren = $menu->children && count($menu->children) > 0;
                        $showDropdown = $menu->display_setting?->show_dropdown;
                    @endphp
                    
                    <li class="relative group">
                        <a href="{{ $translation->url ?? '#' }}" 
                           class="text-white hover:text-gray-100 flex items-center"
                           @if($menu->display_setting?->target)
                           target="{{ $menu->display_setting->target }}"
                           @endif>
                            {{ $translation->name ?? '' }}
                            @if($hasChildren && $showDropdown)
                                <span class="ml-1">▾</span>
                            @endif
                        </a>

                        @if($hasChildren && $showDropdown)
                            <div class="hidden group-hover:block absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                @foreach($menu->children as $child)
                                    @php
                                        $childTranslation = $child->translations->where('language_code', $currentLang)->first();
                                    @endphp
                                    <a href="{{ $childTranslation->url ?? '#' }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $childTranslation->name ?? '' }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Mobile Menu Button and Language Switcher --}}
        <div class="flex items-center space-x-4">
            {{-- Theme Toggle --}}
            <button id="theme-toggle" type="button" class="text-white dark:text-gray-400 hover:bg-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
                </svg>
            </button>

            {{-- Language Switcher --}}
            <div class="flex items-center space-x-2">
                <a href="{{ route('language.switch', 'th') }}" class="text-white text-sm font-medium">ไทย</a>
                <span class="text-white">|</span>
                <a href="{{ route('language.switch', 'en') }}" class="text-white text-sm font-medium">Eng</a>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button data-collapse-toggle="navbar-menu" type="button" class="text-white md:hidden">
                <span class="sr-only">Toggle menu</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        {{-- Mobile Menu Panel --}}
        <div id="navbar-menu" class="hidden fixed inset-0 bg-primary-light z-50 md:hidden">
            <div class="p-4">
                {{-- Mobile Header --}}
                <div class="flex justify-between items-center mb-8">
                    <img src="{{ asset('assets/images/fitm-logo.png') }}" class="h-10" alt="FITM Logo" />
                    <button data-collapse-toggle="navbar-menu" class="text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu Items --}}
                <ul class="space-y-6 text-lg">
                    @foreach($menus as $menu)
                        @php
                            $translation = $menu->translations->where('language_code', $currentLang)->first();
                            $hasChildren = $menu->children && count($menu->children) > 0;
                        @endphp
                        <li>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" 
                                        class="text-white block w-full text-left py-2 flex items-center justify-between">
                                    {{ $translation->name ?? '' }}
                                    @if($hasChildren)
                                        <span class="ml-2" x-bind:class="{'transform rotate-180': open}">▾</span>
                                    @endif
                                </button>

                                @if($hasChildren)
                                    <div x-show="open" class="pl-4 space-y-2 mt-2">
                                        @foreach($menu->children as $child)
                                            @php
                                                $childTranslation = $child->translations->where('language_code', $currentLang)->first();
                                            @endphp
                                            <a href="{{ $childTranslation->url ?? '#' }}" 
                                               class="text-white block py-2">
                                                {{ $childTranslation->name ?? '' }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</nav>