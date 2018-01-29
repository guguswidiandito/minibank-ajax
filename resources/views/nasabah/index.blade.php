@extends('layouts.template')
@section('content')
<div class="clearfix"></div>
<div class="alert alert-success hidden">
  <strong>Success! </strong><span id="message"></span>
</div>
<div class="x_panel tile" id="panel-tambah">
  <div class="x_title">
    <h2 id="title">Tambah Nasabah</h2>
    <ul class="nav navbar-right panel_toolbox">
      <li>
        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
      </li>
      <li>
        <a class="close-link"><i class="fa fa-close"></i></a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <form id="form-nasabah" enctype="multipart">
      {!! Form::hidden('rekening') !!}
      <div class="col-md-3">
        <div class="form-group {{ $errors->has('no_rekening') ? "has-error" : "" }}">
          <label>No Rekening</label>
          {!! Form::text('no_rekening', null, ['class' => 'form-control', 'placeholder' => 'No Rekening']) !!}
          <p class="text-danger" id="no_rekening-error"></p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group {{ $errors->has('nama') ? "has-error" : "" }}">
          <label>Nama</label>
          {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama']) !!}
          <p class="text-danger" id="nama-error"></p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group {{ $errors->has('saldo_awal') ? "has-error" : "" }}">
          <label id="saldo">Saldo Awal</label>
          {!! Form::number('saldo_awal', null, ['class' => 'form-control', 'placeholder' => 'Saldo Awal']) !!}
          <p class="text-danger" id="saldo_awal-error"></p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group {{ $errors->has('alamat') ? "has-error" : "" }}">
          <label>Alamat</label>
          {!! Form::text('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat']) !!}
          <p class="text-danger" id="alamat-error"></p>
        </div>
      </div>
      <div class="col-md-3">
        <button type="button" class="save btn btn-primary">Simpan</button>
        <button type="button" class="hidden update btn btn-primary">Update</button>
        <button type="button" class="cancel btn btn-info">Batal</button>
      </div>
    </form>
  </div>
</div>
<div class="x_panel tile">
  <div class="x_title">
    <h2>Data Nasabah</h2>
    <ul class="nav navbar-right panel_toolbox">
      <li>
        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
      </li>
      <li>
        <a class="close-link"><i class="fa fa-close"></i></a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <table class="table dt-responsive nowrap" cellspacing="0" width="100%" id="list-nasabah">
      <thead>
        <tr>
          <th>No Rekening</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Saldo</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@include('nasabah.modal.hapus')
@endsection
@push('script')
@include('nasabah.js.index')
@endpush