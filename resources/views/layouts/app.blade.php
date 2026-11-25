<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tempat Favoritku')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-[#f7f7f2] font-sans text-stone-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-emerald-950/10 bg-[#f7f7f2]/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('tempats.index') }}" class="group flex items-center gap-3">
                <span class="flex size-11 items-center justify-center rounded-2xl bg-[#173f35] text-[#f4d18c] shadow-lg shadow-emerald-950/10 transition group-hover:-rotate-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 7 1.15 2.33 2.57.37-1.86 1.81.44 2.56L12 12.86l-2.3 1.21.44-2.56-1.86-1.81 2.57-.37L12 7Z" />
                    </svg>
                </span>
                <span>
                    <span class="block text-base font-bold tracking-tight text-[#173f35] sm:text-lg">Tempat Favoritku</span>
                    <span class="hidden text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-500 sm:block">Cerita dari mana saja</span>
                </span>
            </a>

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="rounded-full border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-stone-700 transition hover:border-[#173f35] hover:text-[#173f35]">
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 sm:py-10 lg:px-8 lg:py-12">
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-900 shadow-sm" role="status">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    </svg>
                </span>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-stone-200/80">
        <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-6 text-xs text-stone-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <span>Tempat Favoritku</span>
            <span>Simpan tempat yang berarti, dari mana saja.</span>
        </div>
    </footer>
</body>
</html>
