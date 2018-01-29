<?php

namespace App\Http\Controllers;

use App\Nasabah;
use App\Transaksi;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        return view('nasabah.index');
    }

    public function list() 
    {
        $nasabah = Nasabah::orderBy('nama', 'ASC')->get(['no_rekening', 'saldo_awal', 'nama', 'alamat', 'created_at']);

        return Datatables::of($nasabah)
            ->addColumn('action', function (Nasabah $nasabah) {
                return '<a href="' . route('nasabah.show', $nasabah->no_rekening) . '" class="btn btn-xs btn-success">Transaksi</a><button type="button" class="btn btn-xs btn-default" id="edit" data-rekening="' . $nasabah->no_rekening . '" data-nama="' . $nasabah->nama . '" data-alamat="' . $nasabah->alamat . '" data-saldo="' . $nasabah->saldo_awal . '">Edit</button><button id="hapus" data-rekening="' . $nasabah->no_rekening . '" data-nama="' . $nasabah->nama . '" class="btn btn-xs btn-danger">Hapus</button>';
            })
            ->addColumn('saldo_awal', function (Nasabah $nasabah) {
                return 'Rp.' . number_format($nasabah->saldo_awal);
            })
            ->addColumn('created_at', function (Nasabah $nasabah) {
                return \Carbon\Carbon::parse($nasabah->created_at)->format('D, d-m-Y');
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        return Nasabah::simpan($request);
    }

    public function update(Request $request)
    {
        return Nasabah::updateByNoRekening($request);
    }

    public function destroy(Request $request)
    {
        return Nasabah::hapusByNoRekening($request);
    }

    public function show(Request $request, $no_rekening)
    {
        $nasabah = Nasabah::where('no_rekening', $no_rekening)->first();

        return view('nasabah.transaksi', ['nasabah' => $nasabah]);
    }

    public function listTransaksi($no_rekening)
    {
        $nasabah   = Nasabah::where('no_rekening', $no_rekening)->first();
        $transaksi = Transaksi::with('user')->where('nasabah_id', $nasabah->id)->get();

        return Datatables::of($transaksi)
            ->addColumn('saldo', function (Transaksi $transaksi) {
                return 'Rp.' . number_format($transaksi->saldo);
            })
            ->addColumn('total', function (Transaksi $transaksi) {
                return 'Rp.' . number_format($transaksi->total);
            })
            ->addColumn('created_at', function (Transaksi $transaksi) {
                return \Carbon\Carbon::parse($transaksi->created_at)->format('D, d-m-Y');
            })
            ->make(true);
    }

    public function setTransaksi(Request $request, $no_rekening)
    {
        return Nasabah::bertransaksi($request, $no_rekening);
    }
}
