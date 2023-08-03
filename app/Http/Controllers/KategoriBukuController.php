<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriBuku;
use App\Models\Buku;

class KategoriBukuController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataKategori = KategoriBuku::all();
        $dataBuku = Buku::all();
        return view('kategori', compact('dataKategori', 'dataBuku'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50'
        ]);

        $addKategori = KategoriBuku::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        
        if ($addKategori) {
            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil ditambahkan.');
        } else {
            return redirect()->route('kategori.index')->with('error', 'Data kategori tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50'
        ]);

        $updateKategori = KategoriBuku::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        
        if ($updateKategori) {
            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil disimpan.');
        } else {
            return redirect()->route('kategori.index')->with('error', 'Data kategori gagal disimpan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buku = Buku::where('id_kategori', $id)->get();
        $kategori = KategoriBuku::where('id', $id)->get();
        if ($buku->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Masih ada buku dengan kategori '.$kategori[0]['nama_kategori']);
        }

        $hapusKategori =  KategoriBuku::where('id', $id)->delete();
        if ($hapusKategori) {
            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil dihapus.');
        } else {
            return redirect()->route('kategori.index')->with('error', 'Data kategori gagal dihapus.');
        }
    }
}
