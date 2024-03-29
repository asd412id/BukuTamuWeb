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

  protected $casts = [
    'anggota' => 'array',
    'cin'=>'datetime',
    'cout'=>'datetime'
  ];

  public function getRatingTextAttribute()
  {
    if (!$this->rating) {
      return null;
    }
    switch ($this->rating) {
      case 5:
        $text = 'Memuaskan';
        break;
      case 4:
        $text = 'Sangat Baik';
        break;
      case 3:
        $text = 'Baik';
        break;
      case 2:
        $text = 'Buruk';
        break;
      default:
        $text = 'Mengecewakan';
        break;
    }

    return $text;
  }

  public function getInstansi()
  {
    return $this->belongsTo(\App\Instansi::class,'instansi_id');
  }
}
