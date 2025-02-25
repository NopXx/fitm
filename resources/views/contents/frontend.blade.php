@extends('layout.app')
@section('css')
    @vite(['resources/css/department.css'])
@endsection
@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-8 dark:bg-gray-900">
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
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                            {{ app()->getLocale() == 'th' ? ($content->title_th ?? __('content.content')) : ($content->title_en ?? __('content.content')) }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        @if($content)
            <div class="mt-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ app()->getLocale() == 'th' ? $content->title_th : $content->title_en }}
                </h1>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 mt-4">
                <div class="department-content">
                    {!! app()->getLocale() == 'th' ? $content->detail_th : $content->detail_en !!}
                </div>
            </div>
        @else
            <div class="mt-6">
                <div class="bg-white dark:bg-gray-800 p-6">
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                        {{ __('content.no_content_found') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script-app')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add responsive class to tables if not already added from editor
            const tables = document.querySelectorAll('.content-container table:not(.table-responsive)');
            tables.forEach(table => {
                if (!table.parentElement.classList.contains('table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });

            // Add img-fluid class to images if not already added from editor
            const images = document.querySelectorAll('.content-container img:not(.img-fluid)');
            images.forEach(img => {
                img.classList.add('img-fluid');
            });
        });
    </script>
@endsection
