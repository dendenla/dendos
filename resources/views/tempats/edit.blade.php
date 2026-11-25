@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Edit Tempat</h1>

    <form action="{{ route('tempats.update', $tempat) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-sm">
        @csrf
        @method('PUT')
        @include('tempats._form', ['tempat' => $tempat])
    </form>
@endsection