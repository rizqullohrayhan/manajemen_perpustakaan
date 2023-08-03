<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromCollection, WithHeadings 
{
    use Exportable;
    
    public function __construct(int $user)
    {
        $this->user = $user;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Buku',
            'Kategori',
            'Deskripsi',
            'Jumlah',
            'File',
            'Cover',
            'Penggungah',
        ];
    }
    
    public function collection()
    {
        if($this->user == '1'){
            return Buku::with(['KategoriBuku', 'User'])->get()->map(function ($buku) {
                return [
                    'ID' => $buku->id,
                    'Judul Buku' => $buku->judul_buku,
                    'Kategori' => $buku->kategoriBuku->nama_kategori,
                    'Deskripsi' => $buku->deskripsi,
                    'Jumlah' => $buku->jumlah,
                    'file' => $buku->file_buku,
                    'cover' => $buku->cover_buku,
                    'Penggungah' => $buku->user->name,
                ];
            });
        } else{
            return Buku::with(['KategoriBuku', 'User'])->where('id_user', $this->user)->get()->map(function ($buku) {
                return [
                    'ID' => $buku->id,
                    'Judul Buku' => $buku->judul_buku,
                    'Kategori' => $buku->kategoriBuku->nama_kategori,
                    'Deskripsi' => $buku->deskripsi,
                    'Jumlah' => $buku->jumlah,
                    'file' => $buku->file_buku,
                    'cover' => $buku->cover_buku,
                    'Penggungah' => $buku->user->name,
                ];
            });
        }
    }
}
