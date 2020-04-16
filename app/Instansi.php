<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
  protected $table = 'instansi';

  protected $fillable = ['uuid','nama','alamat','email','telp'];

  public function user()
  {
    return $this->hasMany(\App\User::class,'instansi_id');
  }

  public function configs()
  {
    return $this->hasMany(\App\Configs::class,'instansi_id');
  }

  public function getConfigsAllAttribute()
  {
    $configs = $this->configs()
    ->get()
    ->pluck('value','config')
    ->toArray();

    return (object) $configs;
  }
}
