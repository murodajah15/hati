<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbdivisi extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "tbdivisi";
  protected $guarded = ['id'];
  // protected $fillable = ['kode', 'nama', 'aktif', 'user',];
  public $timestamps = true;
}
