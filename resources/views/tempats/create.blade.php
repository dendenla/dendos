@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Tambah Tempat</h1>

    <form action="{{ route('tempats.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-sm">
        @csrf
        @include('tempats._form', ['tempat' => null])
    </form>
@endsection
