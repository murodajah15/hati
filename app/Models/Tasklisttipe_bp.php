<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasklisttipe_bp extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "tasklisttipe_bp";
  protected $guarded = ['id'];
  // protected $fillable = [
  //   'kode', 'nama', 'lokasi', 'model', 'kdjnbrg', 'kdsatuan', 'nmsatuan', 'kdnegara', 'kdmove', 'harga_beli', 'harga_jual',
  //   'kddiscount', 'nobatch', 'stock_min', 'stock_mak', 'tglexpired', 'user',
  // ];
  public $timestamps = false;
}
