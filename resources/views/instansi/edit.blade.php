@extends('layouts.master')
@section('title',$title)

@section('head_icon')
  <i class="fas fa-user-tie bg-green"></i>
@endsection
@section('head_title',$title)
@section('head_desc',$subtitle)
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('instansi.index') }}">Pengaturan Instansi</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
<form action="{{ route('instansi.update',['uuid'=>$data->uuid]) }}" enctype="multipart/form-data" method="post">
  @csrf
  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-header">
          <h3>Update Data Instansi</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Nama Instansi</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ $data->nama }}" placeholder="Nama Instansi" required>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="5" placeholder="Alamat" class="form-control" required>{{ $data->alamat }}</textarea>
          </div>
          <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $data->email }}" placeholder="Alamat Email">
          </div>
          <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="telp" class="form-control" id="telp" value="{{ $data->telp }}" placeholder="Nomor Telepon">
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> SIMPAN</button>
          <a href="{{ route('instansi.index') }}" class="btn btn-danger"><i class="fa fa-fw fa-undo"></i> KEMBALI</a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('footer')
@if ($errors->any())
<script type="text/javascript">
  @foreach ($errors->all() as $key => $err)
    showDangerToast('{{ $err }}')
  @endforeach
</script>
@endif
@endsection
