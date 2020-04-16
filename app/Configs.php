<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
  protected $table = 'configs';

  protected $fillable = ['instansi_id','config','value'];
  public $timestamps = false;

  public static function getAll()
  {
    $configs = self::select('instansi_id','value','config')
    ->whereNull('instansi_id')
    ->get()
    ->pluck('value','config')
    ->toArray();

    return (object) $configs;
  }
}
