<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbcabang extends Model
{
  use HasFactory;

  // Fillable
  protected $guarded = ['id'];
  protected $table = "tbcabang";
  // protected $fillable = ['kode', 'nama', 'aktif', 'user',];
  public $timestamps = true;
}
