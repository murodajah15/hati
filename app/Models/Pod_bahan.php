<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pod_bahan extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "pod_bahan";

  // protected $fillable = [
  //   'kdbarang', 'nmbarang', 'kdsatuan', 'qty', 'harga', 'discount', 'subtotal', 'nopo', 'terima', 'kurang', 'proses', 'user'
  // ];
  protected $guarded = ['id'];
  public $timestamps = false;
}
