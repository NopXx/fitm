@extends('layout.app')
@section('title')
    {{ app()->getLocale() == 'th' ? $content->title_th ?? __('content.content') : $content->title_en ?? __('content.content') }}
@endsection

@section('css')
    @vite(['resources/css/tinymce-content.css'])
    <style>
        /* Mobile-first adjustments */
        .department-content {
            max-width: 100%;
            margin: 0 auto;
            font-size: 1rem;
            /* Slightly smaller on mobile */
            color: #333;
            line-height: 1.6;
        }

        .department-content img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
            /* Reduced margin on mobile */
            display: block;
        }

        .content-title {
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

        /* Responsive typography and spacing */
        @media (max-width: 640px) {
            .content-container {
                padding: 0 1rem;
                /* Reduced padding on small screens */
            }

            .content-header {
                margin-bottom: 1.5rem;
            }

            .content-title {
                font-size: 1.5rem;
                /* Even smaller on very small screens */
            }

            .department-content {
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
        <div class="content-container">
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2 transition-colors duration-200">
                                {{ app()->getLocale() == 'th' ? $content->title_th ?? __('content.content') : $content->title_en ?? __('content.content') }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if ($content)
                <!-- Content Header -->
                <div class="content-header mb-6">
                    <h1 class="content-title text-gray-900 dark:text-white font-bold mb-4 transition-colors duration-200">
                        {{ app()->getLocale() == 'th' ? $content->title_th : $content->title_en }}
                    </h1>
                </div>

                <!-- Content -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm transition-colors duration-200">
                    <div class="department-content">
                        {!! app()->getLocale() == 'th' ? $content->detail_th : $content->detail_en !!}
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm transition-colors duration-200">
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8 transition-colors duration-200">
                        {{ __('content.no_content_found') }}
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
                tooltip.textContent = '{{ __('content.link_copied') }}';
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

        // Define the fixed domain path
        const fixedDomainPath = '{{ url('/') }}';

        document.addEventListener('DOMContentLoaded', function() {
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
            }

            // Add responsive class to tables if not already added from editor
            const tables = document.querySelectorAll('.department-content table:not(.table-responsive)');
            tables.forEach(table => {
                if (!table.parentElement.classList.contains('table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });

            // Fix ALL image paths to use the specific domain path
            // Fix ALL image paths to use the specific domain path
            const images = document.querySelectorAll('.department-content img');
            images.forEach(img => {
                // Always add fluid class if missing
                if (!img.classList.contains('img-fluid')) {
                    img.classList.add('img-fluid');
                }

                // Get current src
                const currentSrc = img.getAttribute('src');

                if (currentSrc) {
                    // Only process URLs that do NOT start with http:// or https://
                    if (!currentSrc.startsWith('http://') && !currentSrc.startsWith('https://')) {
                        let filename = currentSrc.split('/').pop();

                        // Remove any query parameters if they exist
                        if (filename.includes('?')) {
                            filename = filename.split('?')[0];
                        }

                        // Force update all image sources to use the fixed domain path
                        img.src = fixedDomainPath + '/storage/uploads/department/' + filename;

                        // Add error handler to try alternate path if the image fails to load
                        img.onerror = function() {
                            this.src = fixedDomainPath + '/storage/uploads/contents/' + filename;

                            // Remove the error handler to prevent potential loops
                            this.onerror = null;
                        };

                        // Force set the image path to avoid any issues with browser caching
                        setTimeout(() => {
                            img.setAttribute('src', fixedDomainPath +
                                '/storage/uploads/department/' + filename);
                        }, 0);
                    }
                }
            });
        });
    </script>
@endsection
