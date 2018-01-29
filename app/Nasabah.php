<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Nasabah extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'no_rekening', 'foto', 'saldo_awal',
    ];

    protected static function simpan(Request $request)
    {
        $rules = [
            'nama'        => 'required',
            'alamat'      => 'required',
            'no_rekening' => 'required|unique:nasabahs',
            'saldo_awal'  => 'required|numeric',
        ];

        $data      = $request->except('foto', '_token');
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        } else {
            $nasabah = new Nasabah($data);
            if ($nasabah->save()) {
                return response()->json([
                    'nasabah' => $nasabah,
                    'message' => 'Nasabah berhasil disimpan!',
                ]);
            }

            return false;
        }

        return false;
    }

    protected static function updateByNoRekening(Request $request)
    {
        $rules = [
            'nama'        => 'required',
            'alamat'      => 'required',
            'no_rekening' => 'required',
        ];

        $data      = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        } else {
            $no_rekening = $request->rekening;
            $nasabah     = Nasabah::where('no_rekening', $no_rekening)->firstOrFail();
            if ($nasabah->update($data)) {
                return response()->json([
                    'nasabah' => $nasabah,
                    'message' => 'Nasabah berhasil diupdate!',
                ]);
            }
            return false;
        }
        return false;
    }

    protected static function hapusByNoRekening(Request $request)
    {
        $no_rekening = $request->rekening;
        $nasabah     = Nasabah::where('no_rekening', $no_rekening)->firstOrFail();
        if ($nasabah->delete($request->all())) {
            return response()->json([
                'message' => 'Nasabah berhasil dihapus!',
            ]);
        }
        return false;
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    protected static function bertransaksi(Request $request, $no_rekening)
    {
        $rules = [
            'jenis_transaksi' => 'required',
            'total'           => 'required',
        ];

        $data      = $request->except('_token');
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        } else {
            $nasabah          = Nasabah::where('no_rekening', $no_rekening)->first();
            $transaksi        = new Transaksi();
            $transaksi->total = $request->total;
            if ($request->jenis_transaksi == 'Debet') {
                $transaksi->saldo    = $nasabah->saldo_awal + $transaksi->total;
                $nasabah->saldo_awal = $nasabah->saldo_awal + $transaksi->total;
                $nasabah->save();
            } else {
                $transaksi->saldo    = $nasabah->saldo_awal - $transaksi->total;
                $nasabah->saldo_awal = $nasabah->saldo_awal - $transaksi->total;
                $nasabah->save();
            }
            $transaksi->jenis_transaksi = $request->jenis_transaksi;
            $transaksi->nasabah_id      = $request->nasabah_id;
            if ($request->user()->admin()->save($transaksi)) {
                return response()->json([
                    'message' => 'Transaksi berhasil disimpan!',
                ]);
            }
            return false;
        }
        return false;
    }
}
