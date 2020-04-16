<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'username', 'password', 'role'
    ];

    protected $dates = ['created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function setPasswordAttribute($value)
    {
      return $value?$this->attributes['password']=bcrypt($value):null;
    }

    public function instansi()
    {
      return $this->belongsTo(\App\Instansi::class,'instansi_id');
    }

    public function configs()
    {
      return $this->hasMany(\App\Configs::class,'instansi_id','instansi_id');
    }

    public function getTglDibuatAttribute()
    {
      return $this->created_at?$this->created_at->locale('id')->translatedFormat('j F Y'):null;
    }

    public function getConfigsAllAttribute()
    {
      $configs = $this->configs()
      ->get()
      ->pluck('value','config')
      ->toArray();

      return (object) $configs;
    }

    public function getIsAdminAttribute()
    {
      return $this->role=='admin';
    }

}
