<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poh_bahan extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "poh_bahan";

  // protected $fillable = [
  //   'noso', 'tglso', 'nopo_customer', 'tglpo_customer', 'noreferensi', 'kdcustomer', 'nmcustomer', 'kdsales', 'nmsales', 'tglkirim',
  //   'jenis_order', 'biaya_lain', 'ket_biaya_lain', 'subtotal', 'total_sementara', 'ppn', 'materai', 'total', 'tempo', 'tgl_jt_tempo',
  //   'carabayar', 'keterangan', 'proses', 'batal', 'terima', 'user_proses', 'user'
  // ];

  protected $guarded = ['id'];
  public $timestamps = false;

  public function poDetail()
  {
    return $this->hasMany(Pod_bahan::class, 'nopo', 'nopo');
  }
}