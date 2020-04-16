<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Instansi;

use Validator;
use DataTables;
use Str;

class InstansiController extends Controller
{
  public function generateToken()
  {
    $token = Str::random(100);
    $cek = Instansi::where('_token',$token)->first();
    if ($cek) {
      return $this->generateToken();
    }
    return $token;
  }

  public function index()
  {
    if (request()->ajax()) {
      $data = Instansi::orderBy('nama','asc');
      return DataTables::of($data)
      ->addColumn('action', function($row){

        $btn = '<div class="table-actions">';

        if (\Auth::user()->role == 'admin') {
          $btn .= ' <a href="'.route('instansi.edit',['uuid'=>$row->uuid]).'" class="text-primary" title="Ubah"><i class="ik ik-edit"></i></a>';

          $btn .= ' <a href="'.route('instansi.destroy',['uuid'=>$row->uuid]).'" class="text-danger confirm" data-text="Hapus data '.$row->nama.'?" title="Hapus"><i class="ik ik-trash-2"></i></a>';
        }

        $btn .= '</div>';

        return $btn;
      })
      ->rawColumns(['action'])
      ->make(true);
    }
    $data = [
      'title'=>'Pengaturan Instansi',
      'subtitle'=>'Daftar Instansi',
    ];
    return view('instansi.index',$data);
  }

  public function create()
  {
    $data = [
      'title'=>'Instansi Baru',
      'subtitle'=>'Tambah Instansi Baru',
    ];
    return view('instansi.create',$data);
  }

  public function store(Request $r)
  {
    $rules = [
      'nama'=>'required|unique:instansi,nama',
      'alamat'=>'required',
    ];

    $msgs = [
      'nama.required'=>'Nama Instansi tidak boleh kosong!',
      'nama.unique'=>'Nama Instansi telah digunakan!',
      'nama.alamat'=>'Alamat Instansi tidak boleh kosong!',
    ];

    if ($r->email) {
      $rules['email'] = 'unique:instansi,email';
      $msgs['email.unique'] = 'Alamat Email telah digunakan!';
    }
    if ($r->telp) {
      $rules['telp'] = 'numeric';
      $msgs['telp.numeric'] = 'Format nomor telepon tidak benar!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert = new Instansi;
    $insert->uuid = (string) Str::uuid();
    $insert->nama = $r->nama;
    $insert->alamat = $r->alamat;
    $insert->email = $r->email;
    $insert->telp = $r->telp;
    $insert->_token = $this->generateToken();

    if ($insert->save()) {
      return redirect()->route('instansi.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function edit($uuid)
  {
    $instansi = Instansi::where('uuid',$uuid)->first();
    $data = [
      'title'=>'Update Instansi',
      'subtitle'=>'Update Data Instansi',
      'data'=>$instansi,
    ];
    return view('instansi.edit',$data);
  }

  public function update(Request $r,$uuid)
  {
    $insert = Instansi::where('uuid',$uuid)->first();

    $rules = [
      'nama'=>'required|unique:instansi,nama,'.$uuid.',uuid',
      'alamat'=>'required',
    ];

    $msgs = [
      'nama.required'=>'Nama Instansi tidak boleh kosong!',
      'nama.unique'=>'Nama Instansi telah digunakan!',
      'nama.alamat'=>'Alamat Instansi tidak boleh kosong!',
    ];

    if ($r->email) {
      $rules['email'] = 'unique:instansi,email,'.$uuid.',uuid';
      $msgs['email.unique'] = 'Alamat Email telah digunakan!';
    }
    if ($r->telp) {
      $rules['telp'] = 'numeric';
      $msgs['telp.numeric'] = 'Format nomor telepon tidak benar!';
    }

    Validator::make($r->all(),$rules,$msgs)->validate();

    $insert->nama = $r->nama;
    $insert->alamat = $r->alamat;
    $insert->email = $r->email;
    $insert->telp = $r->telp;

    if ($insert->save()) {
      return redirect()->route('instansi.index')->with('message','Data berhasil disimpan!');
    }
    return redirect()->back()->withErrors('Data gagal disimpan!');
  }

  public function destroy($uuid)
  {
    $instansi = Instansi::where('uuid',$uuid)->first();
    if ($instansi->delete()) {
      return redirect()->route('instansi.index')->with('message','Data berhasil dihapus!');
    }
    return redirect()->back()->withErrors('Data gagal dihapus!');
  }
}
