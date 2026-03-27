<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Exports\BukuExport;
use Excel;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $dataBuku = Buku::with('kategoriBuku')->get();
        } else {
            $user = Auth::user()->id;
            $dataBuku = Buku::where('id_user', $user)->with('kategoriBuku')->get();
        }
        // dd($dataBuku);
        $kategori = KategoriBuku::all();
        return view('buku', compact('dataBuku', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku'    => 'required|string',
            'kategori'      => 'required|numeric',
            'jumlah'        => 'required|numeric',
            'deskripsi'     => 'required|string',
            'cover'         => 'required|mimes:jpeg,png,jpg',
            'fileBuku'      => 'required|mimes:pdf'
        ]);

        $cover = $request->file('cover')->store('cover', 'public');
        $fileBuku = $request->file('fileBuku')->store('buku', 'public');

        $user = Auth::user()->id;
        $addBuku = Buku::create([
            'judul_buku'    => $request->judul_buku,
            'id_kategori'   => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'jumlah'        => $request->jumlah,
            'file_buku'     => $fileBuku,
            'cover_buku'    => $cover,
            'id_user'       => $user,
        ]);

        if ($addBuku) {
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan.');
        } else {
            return redirect()->route('buku.index')->with('error', 'Data buku tidak ditemukan.');
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
        $buku = Buku::where('id', $id)->get();
        $role = Auth::user()->role;
        $owner = $buku[0]['id_user'];
        $user = Auth::user()->id;

        if ($role == 'user' && $user != $owner) {
            return abort(403, "Anda tidak memiliki akses ke data ini");
        }

        $request->validate([
            'judul_buku'    => 'required|string',
            'kategori'      => 'required|numeric',
            'jumlah'        => 'required|numeric',
            'deskripsi'     => 'required|string',
        ]);
        
        $updateBuku = Buku::where('id', $id)->update([
            'judul_buku'    => $request->judul_buku,
            'id_kategori'   => $request->kategori,
            'deskripsi'     => $request->deskripsi,
            'jumlah'        => $request->jumlah,
        ]);
        
        if ($updateBuku) {
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil disimpan.');
        } else {
            return redirect()->route('buku.index')->with('error', 'Data buku gagal disimpan.');
        }
    }

    public function download(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $role = Auth::user()->role;
        $owner = $buku->id_user;
        $user = Auth::user()->id;

        if ($role == 'user' && $user != $owner) {
            return abort(403, "Anda tidak memiliki akses ke data ini");
        }

        // Check if the file exists in storage
        if (!Storage::disk('public')->exists($buku->file_buku)) {
            abort(404, 'File not found');
        }

        // Get the full path to the file
        $path = Storage::disk('public')->path($buku->file_buku);

        // Determine the MIME type (optional, Laravel often handles this)
        $mimeType = Storage::disk('public')->mimeType($buku->file_buku);

        // Return the file response to the browser
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline;'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Buku::where('id', $id)->get();
        $role = Auth::user()->role;
        $owner = $data[0]['id_user'];
        $user = Auth::user()->id;

        if ($role == 'user' && $user != $owner) {
            return abort(403, "Anda tidak memiliki akses ke data ini");
        }

        $file = $data[0]['file_buku'];
        $cover = $data[0]['cover_buku'];

        Storage::delete([$file, $cover]);
        $hapusBuku = Buku::where('id', $id)->delete();

        if ($hapusBuku) {
            return redirect()->route('buku.index')->with('success', 'File buku berhasil dihapus.');
        } else {
            return redirect()->route('buku.index')->with('error', 'File buku gagal dihapus.');
        }
    }

    public function export()
    {
        $user = Auth::user()->id;
        return (new BukuExport($user))->download('dataBuku.xlsx');
    }
}
