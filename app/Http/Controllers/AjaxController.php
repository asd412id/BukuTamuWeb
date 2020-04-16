<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AjaxController extends BaseController
{

  public function searchInstansi(Request $r)
  {
    if ($r->ajax()) {
      $data['results'] = [];
      $users = \App\Instansi::when($r->term,function($q,$role){
        $search = "%".$role."%";
        $q->where('nama','like',$search)
        ->orWhere('alamat','like',$search)
        ->orWhere('email','like',$search)
        ->orWhere('telp','like',$search);
      })
      ->select('id','nama')
      ->orderBy('nama','asc')
      ->get();
      if (count($users)) {
        foreach ($users as $key => $u) {
          array_push($data['results'],[
            'id' => $u->id,
            'text' => $u->nama
          ]);
        }
      }

      return response()->json($data);
    }

    return response()->json([
      'status'=>'error',
      'message'=>'Page not Found'
    ],404);
  }

}
