<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempatController extends Controller
{
    public function index()
    {
        $tempats = Tempat::latest()->get();

        return view('tempats.index', compact('tempats'));
    }

    public function create()
    {
        return view('tempats.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateTempatData($request);
        $data['link_google_maps'] = $this->googleMapsSearchUrl($data['alamat']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tempats', 'public');
        }

        Tempat::create($data);

        return redirect()->route('tempats.index')->with('success', 'Tempat berhasil ditambahkan.');
    }

    public function edit(Tempat $tempat)
    {
        return view('tempats.edit', compact('tempat'));
    }

    public function update(Request $request, Tempat $tempat)
    {
        $data = $this->validateTempatData($request);
        $data['link_google_maps'] = $this->googleMapsSearchUrl($data['alamat']);

        $fotoLama = null;
        if ($request->hasFile('foto')) {
            $fotoLama = $tempat->foto;
            $data['foto'] = $request->file('foto')->store('tempats', 'public');
        }

        $tempat->update($data);

        if ($fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('tempats.index')->with('success', 'Tempat berhasil diperbarui.');
    }

    public function destroy(Tempat $tempat)
    {
        $foto = $tempat->foto;
        $tempat->delete();

        if ($foto) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()->route('tempats.index')->with('success', 'Tempat berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateTempatData(Request $request): array
    {
        return $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'kategori' => 'required|in:makan,belajar,keduanya',
            'alamat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'rentang_harga' => 'nullable|string|max:100',
            'foto' => 'nullable|image|max:5120',
        ]);
    }

    private function googleMapsSearchUrl(string $address): string
    {
        return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($address);
    }
}
