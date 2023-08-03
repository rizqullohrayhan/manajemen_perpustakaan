<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    protected $primaryKey = 'id';
    protected $fillable = ['judul_buku',
                            'id_kategori',
                            'deskripsi',
                            'jumlah',
                            'file_buku',
                            'cover_buku',
                            'id_user',];
    
    public function kategoriBuku()
    {
        return $this->BelongsTo(KategoriBuku::class, 'id_kategori', 'id');
    }
    
    public function user()
    {
        return $this->BelongsTo(User::class, 'id_user', 'id');
    }
}
