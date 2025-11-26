<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id_like';
    public $timestamps = false;
    
    protected $fillable = ['id_artikel', 'id_user'];
    
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel', 'id_artikel');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
