<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbmekanik extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "tbmekanik";
  protected $guarded = ['id'];
  // protected $fillable = ['kode', 'nama', 'aktif', 'user',];
  public $timestamps = true;
}
