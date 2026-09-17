<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('id', 'desc')->get();
        return view('produk', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk',
            // VALIDASI: Wajib, hanya huruf & spasi, DAN HARUS UNIK (tidak boleh sama/duplikat)
            'nama_produk' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'unique:produks,nama_produk'],
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'kode_produk.unique' => 'Kode produk ini sudah terdaftar!',
            'nama_produk.unique' => 'Gagal! Produk dengan nama tersebut sudah ada di database, tidak boleh duplikat!',
            'nama_produk.regex' => 'Nama produk HANYA BOLEH HURUF dan spasi (dilarang pakai angka atau simbol)!'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/produks', $filename);
            $fotoPath = $filename;
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'foto' => $fotoPath
        ]);

        return redirect('/')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $id,
            'nama_produk' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'unique:produks,nama_produk,' . $id],
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'kode_produk.unique' => 'Kode produk sudah digunakan!',
            'nama_produk.unique' => 'Nama produk sudah ada di database!',
            'nama_produk.regex' => 'Nama produk HANYA BOLEH HURUF dan spasi (tanpa angka/simbol)!'
        ]);

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::exists('public/produks/' . $produk->foto)) {
                Storage::delete('public/produks/' . $produk->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/produks', $filename);
            $fotoPath = $filename;
        }

        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'foto' => $fotoPath
        ]);

        return redirect('/')->with('success', 'Produk berhasil diubah!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->foto && Storage::exists('public/produks/' . $produk->foto)) {
            Storage::delete('public/produks/' . $produk->foto);
        }
        $produk->delete();

        return redirect('/')->with('success', 'Produk berhasil dihapus!');
    }
}