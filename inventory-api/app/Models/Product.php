<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tanpa baris ini, data 'name' dan 'stock' akan ditolak Laravel (Error 500)
    protected $fillable = ['sku', 'name', 'stock', 'qr_code'];
}