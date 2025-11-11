<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Compliance Register</title>
     {{-- ✅ Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    @vite(['resources/js/app.js'])
    

    @livewireStyles
</head>

<body>
    <main class="">
         {{ $slot }}
    </main>
    @livewireScripts

    <script type="module" src="/resources/js/app.js"></script>
</body>

</html>