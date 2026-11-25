@extends('layouts.app')

@section('content')
    <div class="max-w-sm mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Login Admin</h1>

        <form action="{{ url('/login') }}" method="POST" class="bg-white p-6 rounded shadow-sm space-y-4">
            @csrf

            @error('email')
                <div class="rounded bg-red-100 text-red-800 px-4 py-3">{{ $message }}</div>
            @enderror

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-stone-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password"
                       class="w-full border border-stone-300 rounded px-3 py-2">
            </div>

            <button class="w-full bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700">Masuk</button>
        </form>
    </div>
@endsection