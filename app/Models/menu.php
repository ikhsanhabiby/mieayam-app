<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $fillable = ['nama_menu', 'harga', 'stok', 'gambar'];
}
