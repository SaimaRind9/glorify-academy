<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- Apply saved theme before page renders -->
        <script>
            (function () {
                const savedTheme = localStorage.getItem('teacher-dashboard-theme');

                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark-mode');
                } else if (!savedTheme) {
                    const prefersDark = window.matchMedia &&
                        window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark-mode');
                    }
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --layout-bg: #f3f4f6;
                --layout-card: #ffffff;
                --layout-text: #111827;
                --layout-muted: #6b7280;
                --layout-border: #e5e7eb;
            }

            html.dark-mode {
                --layout-bg: #090e1a;
                --layout-card: #111827;
                --layout-text: #f8fafc;
                --layout-muted: #94a3b8;
                --layout-border: #253047;
            }

            html,
            body {
                transition:
                    background-color .3s ease,
                    color .3s ease;
            }

            body {
                background: var(--layout-bg);
                color: var(--layout-text);
            }

            .app-wrapper {
                min-height: 100vh;
                background: var(--layout-bg);
                transition: background .3s ease;
            }

            .app-header {
                background: var(--layout-card);
                border-bottom: 1px solid var(--layout-border);
                transition:
                    background .3s ease,
                    border-color .3s ease;
            }

            .app-header-inner {
                color: var(--layout-text);
            }

            html.dark-mode .bg-gray-100 {
                background-color: var(--layout-bg) !important;
            }

            html.dark-mode .bg-white {
                background-color: var(--layout-card) !important;
            }

            html.dark-mode .text-gray-800,
            html.dark-mode .text-gray-900 {
                color: var(--layout-text) !important;
            }

            html.dark-mode .text-gray-500,
            html.dark-mode .text-gray-600,
            html.dark-mode .text-gray-700 {
                color: var(--layout-muted) !important;
            }

            html.dark-mode .border-gray-100,
            html.dark-mode .border-gray-200,
            html.dark-mode .border-gray-300 {
                border-color: var(--layout-border) !important;
            }

            html.dark-mode input,
            html.dark-mode select,
            html.dark-mode textarea {
                background-color: #172033 !important;
                color: #f8fafc !important;
                border-color: #334155 !important;
            }

            html.dark-mode input::placeholder,
            html.dark-mode textarea::placeholder {
                color: #64748b !important;
            }

            html.dark-mode table {
                color: #e2e8f0;
            }

            html.dark-mode thead {
                background: #172033 !important;
            }

            html.dark-mode th,
            html.dark-mode td {
                border-color: #253047 !important;
            }

            html.dark-mode .shadow,
            html.dark-mode .shadow-sm,
            html.dark-mode .shadow-md {
                box-shadow: 0 10px 30px rgba(0, 0, 0, .25) !important;
            }
        </style>
    </head>

    <body class="font-sans antialiased">

        <div class="app-wrapper">

            @include('layouts.navigation')

            @isset($header)
                <header class="app-header">
                    <div class="app-header-inner max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>

        </div>

    </body>
</html>