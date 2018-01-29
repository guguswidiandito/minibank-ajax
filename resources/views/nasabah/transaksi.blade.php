@extends('layouts.template')
@section('content')
<div class="clearfix"></div>
<div class="alert alert-success hidden">
    <strong>Success! </strong><span id="message"></span>
</div>
<div class="x_panel tile">
    <div class="x_title">
        <h2 id="title"></h2>
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
            <form id="form-transaksi">
                <div class="col-md-6">
                    <input type="hidden" name="nasabah_id" value="{{ $nasabah->id }}">
                    <div class="form-group {{ $errors->has('no_rekening') ? "has-error" : "" }}">
                        <label>Total</label>
                        {!! Form::number('total', null, ['class' => 'form-control', 'placeholder' => 'Total']) !!}
                        <p class="text-danger" id="total-error"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('nama') ? "has-error" : "" }}">
                        <label>Jenis Transaksi</label>
                        {!! Form::select('jenis_transaksi', ['Kredit' => 'Kredit', 'Debet' => 'Debet'], null, ['class' => 'form-control', 'placeholder' => 'Jenis Transaksi']) !!}
                        <p class="text-danger" id="jenis_transaksi-error"></p>
                    </div>
                </div>
            </form>
            <div class="col-md-4">
                <button type="button" class="save btn btn-primary" id="simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>
<div class="x_panel tile">
    <div class="x_title">
        <h2>Data Transaksi</h2>
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
        <table class="table dt-responsive nowrap" cellspacing="0" width="100%" id="list-transaksi">
            <thead>
                <tr>
                    <th>Jenis Transaksi</th>
                    <th>Total</th>
                    <th>Saldo Terakhir</th>
                    <th>Operator</th>
                    <th>Tanggal</th>
                </tr>
            </thead>    
        </table>
    </div>
</div>
@endsection
@push('script')
@include('nasabah.js.transaksi', ['nasabah' => $nasabah])
@endpush