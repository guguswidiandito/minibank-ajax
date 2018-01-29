<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
    	'total', 'jenis_transaksi', 'saldo', 'user_id', 'nasabah_id',
    ];

    public function nasabah()
    {
    	return $this->belongsTo(Nasabah::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }	
}
