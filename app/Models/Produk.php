<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // DB
   protected $fillable = ['kode_produk', 'nama_produk', 'harga', 'foto'];
}