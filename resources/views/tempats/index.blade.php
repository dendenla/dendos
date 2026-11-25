@extends('layouts.app')

@section('title', 'Katalog Tempat Favorit')

@section('content')
    <section class="relative isolate overflow-hidden rounded-[2rem] bg-[#173f35] px-6 py-9 text-white shadow-xl shadow-emerald-950/10 sm:px-10 sm:py-12 lg:px-12 lg:py-14">
        <div class="pointer-events-none absolute -right-20 -top-32 -z-10 size-96 rounded-full bg-emerald-300/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 left-1/3 -z-10 size-80 rounded-full bg-amber-300/10 blur-3xl"></div>

        <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-100">
                    <span class="size-1.5 rounded-full bg-[#f4d18c]"></span>
                    Koleksi pribadi · bebas lokasi
                </span>
                <h1 class="mt-6 text-4xl font-semibold leading-[1.08] tracking-tight sm:text-5xl lg:text-6xl">
                    Setiap tempat punya
                    <span class="font-serif italic text-[#f4d18c]">ceritanya.</span>
                </h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-emerald-50/75 sm:text-lg">
                    Simpan semua tempat yang kamu suka—dari sudut kota sampai destinasi jauh—dalam satu koleksi.
                </p>
                <a href="#koleksi" class="mt-8 inline-flex items-center gap-3 rounded-full bg-[#f4d18c] px-5 py-3 text-sm font-bold text-[#173f35] shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-amber-200">
                    Lihat koleksi
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-4" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M7 7h10v10" />
                    </svg>
                </a>
            </div>

            @if ($tempats->isNotEmpty())
                @php($sorotan = $tempats->first())
                <div class="relative mx-auto w-full max-w-lg lg:pr-5">
                    <div class="absolute -left-5 -top-5 size-20 rounded-full border border-[#f4d18c]/35"></div>
                    <div class="absolute -bottom-5 -right-2 size-28 rounded-full bg-[#f4d18c]/15 blur-2xl"></div>
                    <article class="relative overflow-hidden rounded-[1.75rem] border border-white/20 bg-white/10 p-2 shadow-2xl shadow-black/20">
                        <div class="relative h-64 overflow-hidden rounded-[1.25rem] bg-gradient-to-br from-emerald-800 via-[#426b55] to-[#d0a76c] sm:h-72">
                            @if ($sorotan->foto)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($sorotan->foto) }}"
                                     alt="Foto {{ $sorotan->nama_tempat }}" class="size-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-white/70">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="size-20" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 7 1.15 2.33 2.57.37-1.86 1.81.44 2.56L12 12.86l-2.3 1.21.44-2.56-1.86-1.81 2.57-.37L12 7Z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
                            <span class="absolute right-4 top-4 rounded-full border border-white/25 bg-black/20 px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wider text-white backdrop-blur-md">
                                Pilihanmu
                            </span>
                            <div class="absolute inset-x-0 bottom-0 p-5 text-white sm:p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/75">Tempat tersimpan</p>
                                <h2 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">{{ $sorotan->nama_tempat }}</h2>
                                <p class="mt-2 flex items-center gap-2 text-sm text-white/80">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-4 shrink-0" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z" />
                                        <circle cx="12" cy="10" r="2" />
                                    </svg>
                                    {{ $sorotan->alamat }}
                                </p>
                            </div>
                        </div>
                    </article>
                    <div class="absolute -bottom-7 right-5 flex items-center gap-3 rounded-2xl border border-stone-100 bg-white px-4 py-3 text-stone-900 shadow-xl shadow-black/10 sm:right-0">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-[#f7f2e7] text-[#956b2f]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.8 5.67 6.26.91-4.53 4.42 1.07 6.24L12 17.29l-5.6 2.95 1.07-6.24-4.53-4.42 6.26-.91L12 3Z" />
                            </svg>
                        </span>
                        <span>
                            <span class="block text-lg font-bold leading-tight">{{ $tempats->count() }}</span>
                            <span class="text-xs text-stone-500">tempat favorit</span>
                        </span>
                    </div>
                </div>
            @else
                <div class="relative mx-auto flex h-64 w-full max-w-lg items-center justify-center overflow-hidden rounded-[1.75rem] border border-white/15 bg-white/5 sm:h-72">
                    <div class="absolute size-48 rounded-full border border-white/10"></div>
                    <div class="absolute size-72 rounded-full border border-white/10"></div>
                    <div class="flex size-24 items-center justify-center rounded-[2rem] bg-[#f4d18c] text-[#173f35] shadow-2xl shadow-black/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" class="size-12" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="m12 7 1.15 2.33 2.57.37-1.86 1.81.44 2.56L12 12.86l-2.3 1.21.44-2.56-1.86-1.81 2.57-.37L12 7Z" />
                        </svg>
                    </div>
                    <span class="absolute bottom-7 text-sm font-medium text-white/70">Perjalananmu dimulai dari sini</span>
                </div>
            @endif
        </div>
    </section>

    <section id="koleksi" class="mt-14 scroll-mt-28 sm:mt-16">
        <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#8a6c38]">Yang kamu simpan</p>
                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#173f35] sm:text-4xl">Jelajahi koleksi</h2>
                <p class="mt-2 text-sm text-stone-500">Momen baik sering dimulai dari tempat yang tepat.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="rounded-full border border-stone-200 bg-white px-4 py-2 text-sm font-medium text-stone-600 shadow-sm">
                    {{ $tempats->count() }} tempat tersimpan
                </span>
                @auth
                    @if (strcasecmp(auth()->user()->email, (string) config('app.admin_email')) === 0)
                        <a href="{{ route('tempats.create') }}" class="inline-flex items-center gap-2 rounded-full bg-[#173f35] px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-emerald-950/10 transition hover:-translate-y-0.5 hover:bg-[#225749]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                            </svg>
                            Tambah tempat
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
            @forelse ($tempats as $t)
                <article class="group flex flex-col overflow-hidden rounded-[1.5rem] border border-stone-200/80 bg-white shadow-sm shadow-stone-900/[0.03] transition duration-300 hover:-translate-y-1 hover:border-stone-300 hover:shadow-xl hover:shadow-stone-900/[0.08]">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-emerald-100 via-stone-100 to-amber-100">
                        @if ($t->foto)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($t->foto) }}"
                                 alt="Foto {{ $t->nama_tempat }}" class="size-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex size-full items-center justify-center text-emerald-900/35">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="size-16" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5 8 11l4 4 3-3 6 6M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/25 to-transparent"></div>
                        <span class="absolute left-4 top-4 rounded-full border border-white/70 bg-white/90 px-3 py-1.5 text-xs font-semibold capitalize text-[#173f35] shadow-sm backdrop-blur">
                            {{ $t->kategori }}
                        </span>
                        @if ($t->rentang_harga)
                            <span class="absolute bottom-4 right-4 rounded-full bg-[#173f35]/90 px-3 py-1.5 text-xs font-semibold text-white shadow-sm backdrop-blur">
                                {{ $t->rentang_harga }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col p-5 sm:p-6">
                        <h3 class="text-xl font-semibold tracking-tight text-stone-900 transition group-hover:text-[#225749]">{{ $t->nama_tempat }}</h3>
                        @if ($t->catatan)
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-stone-500">{{ $t->catatan }}</p>
                        @endif

                        <div class="mt-5 flex items-start gap-2.5 text-sm text-stone-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="mt-0.5 size-4 shrink-0 text-[#9a7946]" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z" />
                                <circle cx="12" cy="10" r="2" />
                            </svg>
                            <span class="leading-5">{{ $t->alamat }}</span>
                        </div>

                        @if ($t->link_google_maps)
                            <a href="{{ $t->link_google_maps }}" target="_blank" rel="noopener noreferrer"
                               class="mt-4 inline-flex w-fit items-center gap-2 rounded-full bg-[#f7f2e7] px-3.5 py-2 text-sm font-semibold text-[#76582d] transition hover:bg-[#efe3c9]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6v6m-11 5L21 3M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6" />
                                </svg>
                                Buka di Google Maps
                            </a>
                        @endif

                        <div class="mt-auto pt-5">
                            @unless ($t->rentang_harga)
                                <p class="text-sm text-stone-400">Harga belum dicantumkan</p>
                            @endunless

                            @auth
                                @if (strcasecmp(auth()->user()->email, (string) config('app.admin_email')) === 0)
                                    <div class="mt-4 flex items-center gap-4 border-t border-stone-100 pt-4">
                                        <a href="{{ route('tempats.edit', $t) }}" class="text-sm font-semibold text-[#225749] transition hover:text-[#173f35] hover:underline">Edit</a>
                                        <form action="{{ route('tempats.destroy', $t) }}" method="POST"
                                              onsubmit="return confirm('Hapus tempat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-medium text-rose-600 transition hover:text-rose-800 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-[1.5rem] border border-dashed border-stone-300 bg-white px-6 py-14 text-center shadow-sm">
                    <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-[#f7f2e7] text-[#956b2f]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" class="size-7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                        </svg>
                    </span>
                    <h3 class="mt-5 text-lg font-semibold text-[#173f35]">Koleksimu dimulai di sini</h3>
                    <p class="mt-2 text-sm text-stone-500">Tambahkan tempat pertama yang ingin kamu simpan.</p>
                    @auth
                        @if (strcasecmp(auth()->user()->email, (string) config('app.admin_email')) === 0)
                            <a href="{{ route('tempats.create') }}" class="mt-6 inline-flex rounded-full bg-[#173f35] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#225749]">
                                Tambah tempat
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>
    </section>
@endsection