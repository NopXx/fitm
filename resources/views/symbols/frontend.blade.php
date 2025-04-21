@extends('layout.app')
@section('title')
    @lang('symbol.title')
@endsection
@section('css')
    <style>
        /* Custom Timeline Styling */
        .timeline-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline-container::after {
            content: '';
            position: absolute;
            width: 2px;
            background-color: #e5e7eb;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -1px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 40px;
            width: 50%;
        }

        .timeline-item.left {
            left: 0;
            padding-right: 40px;
        }

        .timeline-item.right {
            left: 50%;
            padding-left: 40px;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #3b82f6;
            border: 4px solid #ffffff;
            top: 15px;
            z-index: 1;
        }

        .timeline-item.left::after {
            right: -10px;
        }

        .timeline-item.right::after {
            left: -10px;
        }

        .timeline-content {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .symbol-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Language switcher */
        .lang-switcher button.active {
            background-color: #3b82f6;
            color: white;
        }

        /* Color swatch */
        .color-swatch {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 5px;
            vertical-align: middle;
            border: 1px solid rgba(0,0,0,0.1);
        }

        /* Dark mode adjustments */
        .dark .timeline-container::after {
            background-color: #374151;
        }

        .dark .timeline-item::after {
            background-color: #3b82f6;
            border-color: #1f2937;
        }

        .dark .timeline-content {
            background-color: #1f2937;
        }

        .dark .color-swatch {
            border-color: rgba(255,255,255,0.1);
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .timeline-container::after {
                left: 31px;
            }

            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .timeline-item.left {
                left: 0;
                padding-right: 25px;
            }

            .timeline-item.right {
                left: 0;
                padding-right: 25px;
            }

            .timeline-item.left::after,
            .timeline-item.right::after {
                left: 21px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-8 dark:bg-gray-900">
        <!-- Header Section -->
        <div class="mb-8">
            <!-- Breadcrumbs -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            @lang('translation.home')
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">@lang('symbol.title')</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="mt-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">@lang('symbol.title')</h1>
            </div>

        </div>

        <!-- Content Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <!-- Timeline Container -->
            <div class="p-6">
                <div class="timeline-container" id="timeline-container">
                    @foreach ($symbols as $index => $symbol)
                        <div class="timeline-item {{ $index % 2 == 0 ? 'left' : 'right' }}">
                            <div class="timeline-content dark:bg-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ app()->getLocale() == 'th' ? $symbol->name_th : $symbol->name_en }}
                                    </h3>
                                </div>

                                <div class="mt-3 prose prose-sm max-w-none text-gray-700 dark:text-gray-300">
                                    {!! app()->getLocale() == 'th' ? $symbol->description_th : $symbol->description_en !!}
                                </div>

                                @if ($symbol->type == 'university_color')
                                    <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">@lang('symbol.color_codes')</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <div class="flex items-center">
                                                @php
                                                    $rgbValues = explode(',', $symbol->rgb_code);
                                                    $rgbColor = 'rgb(' . $symbol->rgb_code . ')';
                                                @endphp
                                                <span class="color-swatch" style="background-color: {{ $rgbColor }}"></span>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                                    <strong>RGB:</strong> {{ $symbol->rgb_code }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                                    <strong>CMYK:</strong> {{ $symbol->cmyk_code }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($symbol->image_path)
                                    <div class="mt-4">
                                        <img src="{{ asset('storage/' . $symbol->image_path) }}"
                                             alt="{{ app()->getLocale() == 'th' ? $symbol->name_th : $symbol->name_en }}"
                                             class="symbol-image">
                                    </div>
                                @endif

                                @if ($symbol->download_link)
                                    <div class="mt-4">
                                        <a href="{{ $symbol->download_link }}"
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                           target="_blank">
                                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            @lang('symbol.download')
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Add animation to timeline dots on scroll
            const timelineItems = document.querySelectorAll('.timeline-item');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeIn');
                        // Add pulse animation to the dot
                        const dot = entry.target;
                        dot.style.animation = 'pulse 2s infinite';
                    }
                });
            }, { threshold: 0.1 });

            timelineItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endsection
