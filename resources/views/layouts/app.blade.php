<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <title>@yield('title', 'Petra Borrow | Sistem Peminjaman Kampus')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="w-full max-w-[1440px] mx-auto flex-grow">
        @yield('content')
    </main>

    <footer class="w-full py-8 px-6 md:px-10 bg-surface-container-highest flex flex-col md:flex-row justify-between items-center max-w-[1440px] mx-auto border-t border-border-subtle mt-12">
        <div class="flex flex-col items-center md:items-start mb-6 md:mb-0">
            <span class="text-title-md font-title-md font-bold text-primary mb-2">Petra Borrow</span>
            <p class="text-body-md font-body-md text-on-surface-variant">© 2026 Petra Christian University. All rights reserved.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <a class="text-on-surface-variant hover:text-primary transition-colors hover:underline text-sm" href="#">Privacy Policy</a>
            <a class="text-on-surface-variant hover:text-primary transition-colors hover:underline text-sm" href="#">Terms of Service</a>
            <a class="text-on-surface-variant hover:text-primary transition-colors text-sm" href="#">Contact BAA</a>
        </div>
    </footer>

    @stack('scripts')

</body>
</html>