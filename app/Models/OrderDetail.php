<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = ['id'];
}
