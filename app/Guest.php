<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
  protected $table = 'guest';

  protected $fillable = [
    'uuid',
    'nama',
    'alamat',
    'telp',
    'pekerjaan',
    'tujuan',
    'anggota',
    'cin',
    'cout',
    '_token',
    'rating',
    'kesan'
  ];

  protected $dates = [
    'cin',
    'cout'
  ];

  protected $casts = [
    'anggota' => 'array'
  ];
}
