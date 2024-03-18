<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sod_bahan extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "sod_bahan";

  // protected $fillable = [
  //   'kdbarang', 'nmbarang', 'kdsatuan', 'qty', 'harga', 'discount', 'subtotal', 'noso', 'terima', 'kurang', 'proses', 'user'
  // ];

  protected $guarded = ['id'];
  public $timestamps = false;
}
