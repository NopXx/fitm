<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            FITM - Faculty of Industrial Technology and Management
        @endif
    </title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const themeVersionKey = 'site-theme-version';
            const currentThemeVersion = '20251110';
            const storedThemeVersion = localStorage.getItem(themeVersionKey);

            if (storedThemeVersion !== currentThemeVersion) {
                localStorage.removeItem('color-theme');
                localStorage.setItem(themeVersionKey, currentThemeVersion);
            }

            const storedTheme = localStorage.getItem('color-theme');
            if (storedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                if (storedTheme === null) {
                    localStorage.setItem('color-theme', 'light');
                }
            }
        })();
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" />
    @yield('css')
</head>

<body class="bg-white dark:bg-gray-900 min-h-screen flex flex-col">
    @include('layout.navbar-app')
    <div class="flex-grow bg-white dark:bg-gray-900">
        <div id="main-content" class="relative w-full bg-white dark:bg-gray-900">
            <main>
                @yield('content')
            </main>
        </div>
    </div>
    @include('layout.footer-app')
    @include('layout.script-app')
</body>

</html>
