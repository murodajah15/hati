<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbjenis extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "tbjenis";
  protected $fillable = ['kode', 'nama', 'aktif', 'user',];
  public $timestamps = true;
}
