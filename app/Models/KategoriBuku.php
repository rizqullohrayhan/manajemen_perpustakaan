<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;
    protected $table = 'kategori_bukus';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kategori'];

    public function buku()
    {
        return $this->HasMany(Buku::class, 'id_kategori', 'id');
    }
}
