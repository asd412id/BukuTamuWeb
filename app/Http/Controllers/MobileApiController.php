<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Guest;
use App\Instansi;
use Str;
use Carbon\Carbon;

class MobileApiController extends Controller
{
  public function __construct()
  {
    $this->err_code = 403;
    $this->acc_code = 202;
    $this->err_msg = 'Akses Ditolak!';
  }

  public function index(Request $r)
  {
    $instansi = Instansi::where('_token',$r->header('instansi'))->first();
    $code = $this->err_code;
    if (!$instansi) {
      $data = [
        'status'=>'error',
        'message'=>'Kode QR tidak dikenali!'
      ];
    }else{
      $dataInstansi = $instansi;
      $configs = $instansi->configs_all;
      $dataInstansi->nama = @$configs->nama_instansi??$instansi->nama;
      if ($configs && $configs->start_clock && $configs->end_clock) {
        $start = Carbon::createFromFormat('H:i',$configs->start_clock);
        $end = Carbon::createFromFormat('H:i',$configs->end_clock);
        $now = Carbon::now();
        if ($now->lessThan($start) || $now->greaterThan($end)) {
          $data = [
            'status'=>'error',
            'message'=>"Jam kunjungan tidak tersedia!\nSilahkan berkunjung pada pukul ".$configs->start_clock." s.d. ".$configs->end_clock
          ];
        }else{
          $code = $this->acc_code;
          $data = [
            'status'=>'connected',
            'data'=>$dataInstansi
          ];
        }
      }else {
        $code = $this->acc_code;
        $data = [
          'status'=>'connected',
          'data'=>$dataInstansi
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function startVisit(Request $r)
  {
    $instansi = Instansi::where('_token',$r->header('instansi'))->first();
    $code = 500;
    if (!$instansi) {
      $data = [
        'status'=>'error',
        'message'=>'Kode QR tidak dikenali!'
      ];
    }else {
      $guest = json_decode($r->header('user-data'));

      $insert = new Guest;
      $insert->uuid = Str::uuid();
      $insert->nama = $guest->nama;
      $insert->alamat = $guest->alamat;
      $insert->telp = $guest->telp;
      $insert->pekerjaan = $guest->pekerjaan;
      $insert->tujuan = $guest->tujuan;
      $insert->anggota = @$guest->anggota?explode("\n",$guest->anggota):null;
      $insert->cin = Carbon::now();
      $insert->instansi_id = $instansi->id;
      $insert->_token = $guest->_token;

      if ($insert->save()) {
        $code = $this->acc_code;
        $data = [
          'status'=>'success',
          'data'=>$insert
        ];
      }else {
        $data = [
          'status'=>'error',
          'message'=>'Permintaan tidak dapat diproses!'
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function endVisit(Request $r)
  {
    $guest = Guest::where('uuid',$r->header('visitid'))
    ->whereNull('cout')
    ->first();
    $code = $this->err_code;
    if (!$guest) {
      $data = [
        'status'=>'error',
        'message'=>'Anda belum berkunjung sebelumnya!'
      ];
    }else {
      $guest->cout = Carbon::now();
      $guest->rating = $r->header('rating');
      $guest->kesan = $r->header('kesan');

      if ($guest->save()) {
        $code = $this->acc_code;
        $data = [
          'status'=>'success',
          'data'=>'Terima Kasih atas Kunjungan Anda'
        ];
      }else {
        $data = [
          'status'=>'error',
          'message'=>'Permintaan tidak dapat diproses!'
        ];
      }
    }
    return $this->returnResponse($data,$code);
  }

  public function returnResponse($data,$code)
  {
    return response()->json($data,$code);
  }
}
