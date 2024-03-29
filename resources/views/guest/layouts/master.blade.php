@extends('layouts.master')
@section('title',$title)
@section('header')
  <link rel="stylesheet" href="{{ url('assets/vendor/jquery.datetimepicker/jquery.datetimepicker.min.css') }}">
  <style media="screen">
    .nowrap{
      white-space: nowrap;
    }
    .wrap{
      white-space: normal;
    }
    .table-guest td{
      text-align: left;
    }
    .text-center{
      text-align: center;
    }
    .text-left{
      text-align: left;
    }
  </style>
@endsection
@section('head_icon')
  <i class="fas fa-clipboard-list bg-danger"></i>
@endsection
@section('head_title',$title)
@section('head_desc',$subtitle)
@section('breadcrumb')
  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('guest.show') }}" method="post">
          @csrf
          <div class="row">
            <div class="{{ auth()->user()->is_admin?'col-sm-3':'col-sm-6' }}">
              <input type="text" class="form-control" value="{{ request()->title??'Rekap Buku Tamu' }}" name="title" id="title" title="Title Rekap Buku Tamu">
            </div>
            @if (auth()->user()->is_admin)
              <div class="col-sm-3">
                <select class="form-control select2-ajax" data-placeholder="Pilih Instansi" data-url="{{ route('ajax.instansi') }}" name="instansi" required>
                  @if ($instansi)
                    <option selected value="{{ $instansi->id }}">{{ $instansi->nama }}</option>
                  @endif
                </select>
              </div>
            @endif
            <div class="col-sm-4">
              <div class="input-group" id="range">
                <div class="input-group-append">
                  <span class="input-group-text">Tanggal</span>
                </div>
                <input type="text" class="form-control" value="{{ request()->start_date??date('Y/m/d') }}" name="start_date" id="start_date">
                <div class="input-group-append">
                  <span class="input-group-text">s.d.</span>
                </div>
                <input type="text" class="form-control" value="{{ request()->end_date??date('Y/m/d') }}" name="end_date" id="end_date">
              </div>
            </div>
            <div class="col-sm-2 p0 nowrap" style="margin-top: 3px">
              <button type="submit" class="btn btn-primary btn-cari" onclick="$(this).closest('form').prop('target','_self')">Cari</button>
              @if (@count($data))
                <input type="submit" name="download_pdf" value="Download" class="btn btn-danger" style="position: relative">
              @endif
            </div>
          </div>
        </form>
        <div class="row">
          @yield('log-content')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer')
<script src="{{ url('assets/vendor/jquery.datetimepicker/jquery.datetimepicker.full.min.js') }}" charset="utf-8"></script>
<script type="text/javascript">
  $(function(){
   $('#start_date').datetimepicker({
    format:'Y/m/d',
    onShow:function( ct ){
      let end_date = $('#end_date').val();
      this.setOptions({
        maxDate:end_date?end_date:false
      })
    },
    timepicker:false
   });
   $('#end_date').datetimepicker({
    format:'Y/m/d',
    onShow:function( ct ){
      let start_date = $('#start_date').val();
      this.setOptions({
        minDate:start_date?start_date:false
      })
    },
    timepicker:false
   });
  });
  @if (session()->has('message'))
    showSuccessToast('{{ session()->get('message') }}')
  @elseif ($errors->any())
    @foreach ($errors->all() as $key => $err)
      showDangerToast('{{ $err }}')
    @endforeach
  @endif
</script>
@endsection
