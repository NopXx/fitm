@extends('layout.app')
@section('title')
    {{ Str::limit($news->title, 40) }}
@endsection

@section('css')
    @vite(['resources/css/tinymce-content.css'])
    <style>
        /* Existing styles with mobile-first adjustments */
        .news-content {
            max-width: 100%;
            margin: 0 auto;
            font-size: 1rem;
            /* Slightly smaller on mobile */
            color: #333;
            line-height: 1.6;
        }

        .news-content img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
            /* Reduced margin on mobile */
            display: block;
        }

        .news-title {
            font-size: 1.75rem;
            /* Smaller title on mobile */
            line-height: 1.2;
        }

        /* Breadcrumb mobile adjustments */
        .breadcrumb-container {
            overflow-x: auto;
            /* Allow horizontal scrolling if needed */
            white-space: nowrap;
        }

        /* Share buttons mobile layout */
        .share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        /* Related news mobile grid */
        .related-news-grid {
            grid-template-columns: 1fr;
            /* Single column on mobile */
        }

        /* Responsive typography and spacing */
        @media (max-width: 640px) {
            .news-content-container {
                padding: 0 1rem;
                /* Reduced padding on small screens */
            }

            .news-header {
                margin-bottom: 1.5rem;
            }

            .news-title {
                font-size: 1.5rem;
                /* Even smaller on very small screens */
            }

            .news-content {
                font-size: 0.95rem;
                /* Slightly smaller font on mobile */
            }

            /* Adjust share button sizes for mobile */
            .share-buttons a,
            .share-buttons button {
                width: 2.5rem;
                height: 2.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8 dark:bg-gray-900 transition-colors duration-200">
        <div class="news-content-container">
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex flex-wrap items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            {{ __('common.home') }}
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('news.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2 transition-colors duration-200">{{ __('news.news') }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2 transition-colors duration-200">{{ Str::limit($news->title, 40) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- News Header - Type and Date -->
            <div class="news-header">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    @if (isset($news->new_type))
                        @php
                            $newTypeName = '';
                            if (is_object($news->new_type) && isset($news->new_type->name)) {
                                $newTypeName = $news->new_type->name;
                            } elseif (is_numeric($news->new_type)) {
                                $newType = \App\Models\NewType::select('new_type_name as name')->find($news->new_type);
                                $newTypeName = $newType ? $newType->name : '';
                            }
                        @endphp
                        @if ($newTypeName)
                            <span
                                class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold px-2.5 py-0.5 rounded transition-colors duration-200">{{ $newTypeName }}</span>
                        @endif
                    @endif

                    <span class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-200 date-format"
                        data-date="@if ($news->effective_date) @if (is_string($news->effective_date))
                                        {{ $news->effective_date }}
                                    @else
                                        {{ $news->effective_date->format('Y-m-d') }} @endif
@else
{{ now()->format('Y-m-d') }}
                                  @endif">
                        <!-- Date will be filled by Moment.js -->
                    </span>
                </div>

                <!-- Get the appropriate title based on language -->
                @php
                    // Get current locale
                    $currentLocale = app()->getLocale();
                    $title = $news->title; // Default title

                    // Use language-specific fields if available
                    if ($currentLocale === 'en' && !empty($news->title_en)) {
                        $title = $news->title_en;
                    } elseif ($currentLocale === 'th' && !empty($news->title_th)) {
                        $title = $news->title_th;
                    }
                @endphp

                <!-- Title -->
                <h1 class="news-title">{{ $title }}</h1>
            </div>

            <!-- News Content -->
            <div class="news-content">
                @php
                    // Get current locale
                    $currentLocale = app()->getLocale();
                    $detail = $news->detail ?? ($news->description ?? ''); // Default detail
                    $content = $news->content ?? ''; // Default content

                    // Use language-specific fields if available
                    if ($currentLocale === 'en') {
                        if (!empty($news->detail_en)) {
                            $detail = $news->detail_en;
                        }
                        if (!empty($news->content_en)) {
                            $content = $news->content_en;
                        }
                    } elseif ($currentLocale === 'th') {
                        if (!empty($news->detail_th)) {
                            $detail = $news->detail_th;
                        }
                        if (!empty($news->content_th)) {
                            $content = $news->content_th;
                        }
                    }
                @endphp

                @if (!empty($detail))
                    <div class="mb-6">
                        <p>{{ $detail }}</p>
                    </div>
                @endif

                @if (!empty($content))
                    <div class="department-content">
                        {!! $content !!}
                    </div>
                @endif

                <!-- Display external link if available -->
                @if (!empty($news->link))
                    <div
                        class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold mb-2">{{ __('news.external_link') }}</h3>
                        <a href="{{ $news->link }}" target="_blank"
                            class="text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center">
                            {{ $news->link }}
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z">
                                </path>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z">
                                </path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Share Buttons -->
            {{-- <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6 transition-colors duration-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 transition-colors duration-200">
                    {{ __('news.share_article') }}</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        target="_blank"
                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($title) }}"
                        target="_blank"
                        class="text-blue-400 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                            </path>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($title) }}"
                        target="_blank"
                        class="text-blue-700 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <button onclick="copyToClipboard('{{ url()->current() }}')"
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                            </path>
                        </svg>
                    </button>
                </div>
            </div> --}}

            <!-- Related News -->
            @if (count($relatedNews) > 0)
                <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8 transition-colors duration-200">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 transition-colors duration-200">
                        {{ __('news.related_news') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relatedNews as $related)
                            @php
                                // Get language-specific title for related news
                                $relatedTitle = $related->title;
                                if (app()->getLocale() === 'en' && !empty($related->title_en)) {
                                    $relatedTitle = $related->title_en;
                                } elseif (app()->getLocale() === 'th' && !empty($related->title_th)) {
                                    $relatedTitle = $related->title_th;
                                }
                            @endphp
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md overflow-hidden hover:shadow-lg transition-all duration-200">
                                <a href="{{ route('news.show', $related->id) }}" class="block overflow-hidden">
                                    <img class="rounded-t-lg w-full h-40 object-cover hover:scale-105 transition-transform duration-300"
                                        src="{{ isset($related->cover) ? asset('storage/' . $related->cover) : (isset($related->cover_image) && $related->cover_image ? asset('storage/' . $related->cover_image) : asset('assets/images/fitm-logo.png')) }}"
                                        alt="{{ $relatedTitle }}">
                                </a>
                                <div class="p-4">
                                    <h5
                                        class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white transition-colors duration-200 line-clamp-2">
                                        {{ Str::limit($relatedTitle, 60) }}
                                    </h5>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transition-colors duration-200 date-format"
                                        data-date="@if ($related->effective_date) @if (is_string($related->effective_date))
                                                        {{ $related->effective_date }}
                                                    @else
                                                        {{ $related->effective_date->format('Y-m-d') }} @endif
@else
{{ now()->format('Y-m-d') }}
                                                  @endif">
                                        <!-- Date will be filled by Moment.js -->
                                    </div>
                                    <a href="{{ route('news.show', $related->id) }}"
                                        class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                                        {{ __('news.read_more') }}
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
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Create a tooltip/alert
                const tooltip = document.createElement('div');
                tooltip.textContent = '{{ __('news.link_copied') }}';
                tooltip.className =
                    'fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300';
                document.body.appendChild(tooltip);

                // Remove tooltip after 2 seconds
                setTimeout(() => {
                    tooltip.classList.add('opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(tooltip);
                    }, 300);
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        // Format dates with Moment.js
        document.addEventListener('DOMContentLoaded', function() {
            // Format all dates on the page
            document.querySelectorAll('.date-format').forEach(function(element) {
                const dateString = element.getAttribute('data-date');
                if (dateString) {
                    // Use Moment.js to format the date
                    // You can customize the format pattern as needed
                    const formattedDate = moment(dateString.trim()).format('LL'); // Localized date format
                    element.textContent = formattedDate;
                }
            });

            // Fix for list styling in department-content
            const contentDiv = document.querySelector('.department-content');

            if (contentDiv) {
                // Fix for lists that don't display bullet points
                const allLists = contentDiv.querySelectorAll('ul');
                allLists.forEach(list => {
                    list.style.listStyleType = 'disc';

                    // Ensure all list items have proper display style
                    const items = list.querySelectorAll('li');
                    items.forEach(item => {
                        item.style.display = 'list-item';
                        item.style.marginBottom = '0.5rem';
                    });
                });

                // Fix for ordered lists
                const orderedLists = contentDiv.querySelectorAll('ol');
                orderedLists.forEach(list => {
                    list.style.listStyleType = 'decimal';

                    // Ensure all list items have proper display style
                    const items = list.querySelectorAll('li');
                    items.forEach(item => {
                        item.style.display = 'list-item';
                        item.style.marginBottom = '0.5rem';
                    });
                });

                // Fix link colors
                const links = contentDiv.querySelectorAll('a');
                links.forEach(link => {
                    if (!link.hasAttribute('style') || !link.getAttribute('style').includes('color')) {
                        link.style.color = '#3b82f6';
                        link.style.textDecoration = 'underline';
                    }
                });

                // Fix code blocks if present
                const codeBlocks = contentDiv.querySelectorAll('code, pre');
                codeBlocks.forEach(block => {
                    if (!block.hasAttribute('style') || !block.getAttribute('style').includes(
                            'background')) {
                        block.style.backgroundColor = '#f3f4f6';
                        block.style.padding = block.tagName === 'PRE' ? '1rem' : '0.2em 0.4em';
                        block.style.borderRadius = block.tagName === 'PRE' ? '5px' : '3px';
                        block.style.fontFamily =
                            'SFMono-Regular, Consolas, Liberation Mono, Menlo, monospace';
                    }
                });

                const fixedDomainPath = '{{ url('/') }}';

                const images = document.querySelectorAll('.department-content img');
                images.forEach(img => {
                    // Always add fluid class if missing
                    if (!img.classList.contains('img-fluid')) {
                        img.classList.add('img-fluid');
                    }

                    // Get current src
                    const currentSrc = img.getAttribute('src');

                    if (currentSrc) {
                        // Extract only the filename from the path
                        let filename = currentSrc.split('/').pop();

                        // Remove any query parameters if they exist
                        if (filename.includes('?')) {
                            filename = filename.split('?')[0];
                        }

                        // Force update all image sources to use the fixed domain path
                        img.src = fixedDomainPath + '/storage/uploads/news/' + filename;

                        // Force set the image path to avoid any issues with browser caching
                        setTimeout(() => {
                            img.setAttribute('src', fixedDomainPath +
                                '/storage/uploads/news/' + filename);
                        }, 0);
                    }
                });
            }
        });
    </script>
@endsection
