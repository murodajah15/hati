<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sod extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "sod";

  // protected $fillable = [
  //   'kdbarang', 'nmbarang', 'kdsatuan', 'qty', 'harga', 'discount', 'subtotal', 'noso', 'terima', 'kurang', 'proses', 'user'
  // ];

  protected $guarded = ['id'];
  public $timestamps = false;
}
