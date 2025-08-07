<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'BimmerWorks')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white">
    @include('partials.navbar')
    <main class="px-6 py-4">
        @yield('content')
    </main>
    @include('partials.footer')
</body>
</html>
