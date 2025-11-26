<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    
    protected $fillable = ['nama_kategori'];
    
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_kategori', 'id_kategori');
    }
}
