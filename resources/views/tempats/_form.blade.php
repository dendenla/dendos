@if ($errors->any())
    <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-3">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label class="block mb-1 font-medium">Nama tempat</label>
        <input type="text" name="nama_tempat" value="{{ old('nama_tempat', $tempat?->nama_tempat) }}"
               class="w-full border border-stone-300 rounded px-3 py-2">
    </div>

    <div>
        <label class="block mb-1 font-medium">Kategori</label>
        <select name="kategori" class="w-full border border-stone-300 rounded px-3 py-2">
            @foreach (['makan', 'belajar', 'keduanya'] as $k)
                <option value="{{ $k }}" @selected(old('kategori', $tempat?->kategori) === $k)>{{ ucfirst($k) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="alamat" class="block mb-1 font-medium">Alamat tempat</label>
        <input id="alamat" type="text" name="alamat" value="{{ old('alamat', $tempat?->alamat) }}"
               placeholder="Masukkan nama tempat atau alamat lengkap"
               required
               class="w-full border border-stone-300 rounded px-3 py-2">
    </div>

    <div>
        <label class="block mb-1 font-medium">Catatan</label>
        <textarea name="catatan" rows="3"
                  class="w-full border border-stone-300 rounded px-3 py-2">{{ old('catatan', $tempat?->catatan) }}</textarea>
    </div>

    <div>
        <label class="block mb-1 font-medium">Rentang harga</label>
        <input type="text" name="rentang_harga" value="{{ old('rentang_harga', $tempat?->rentang_harga) }}"
               placeholder="contoh: 15rb - 30rb"
               class="w-full border border-stone-300 rounded px-3 py-2">
    </div>

    <div>
        <label for="foto" class="block mb-1 font-medium">Foto tempat</label>
        @if ($tempat?->foto)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($tempat->foto) }}"
                 alt="Foto {{ $tempat->nama_tempat }}" class="mb-3 h-40 rounded object-cover">
        @endif
        <input id="foto" type="file" name="foto" accept="image/*"
               class="w-full rounded border border-stone-300 px-3 py-2">
        <p class="mt-1 text-sm text-stone-500">Format gambar, maksimal 5 MB. Kosongkan jika tidak ingin mengganti foto.</p>
    </div>

    <div class="flex gap-2">
        <button class="bg-stone-800 text-white px-4 py-2 rounded hover:bg-stone-700">Simpan</button>
        <a href="{{ route('tempats.index') }}" class="px-4 py-2 rounded border border-stone-300">Batal</a>
    </div>
</div>
