<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosCIU extends Model
{
    //protected $connection = 'sqlsrv';
    protected $table = 'posCIU';
    protected $primaryKey = 'nomor_resi'; // Set the primary key
    public $incrementing = false; // Disable auto-incrementing if the key is not numeric
   
    protected $fillable = [
        'nomor_resi', 'ErrorCode', 'ErrorMessage', 'nomor_sertifikat',
        'kode_cabang', 'user_input', 'tanggal_input', 'tanggal_pengiriman',
        'tanggal_penerimaan', 'nama_pengirim', 'alamat_pengirim', 'telepon_pengirim',
        'nama_penerima', 'alamat_penerima', 'telepon_penerima', 'jenis_barang',
        'berat_barang', 'jumlah_barang', 'harga_barang', 'harga_barang1',
        'harga_pengiriman', 'harga_pengiriman1', 'harga_pertanggungan', 'premium',
        'premium1', 'pengiriman_melalui', 'Status', 'jenis_plan', 'jenis_plan1', 'UserId'
    ];

    public $timestamps = false; // if the table doesn't have created_at and updated_at columns
}

