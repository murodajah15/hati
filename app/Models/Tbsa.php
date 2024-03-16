<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsa extends Model
{
  use HasFactory;

  // Fillable
  protected $table = "tbsa";
  protected $guarded = ['id'];
  // protected $fillable = ['kode', 'nama', 'aktif', 'user',];
  public $timestamps = true;
}
