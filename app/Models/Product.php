<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'id_barang';

    public $incrementing = true;

    public $timestamps = false; // Karena tidak ada field created_at dan updated_at

    protected $fillable = [
        'kd_barang',
        'nm_barang',
        'stok_barang',
        'stok_buffer',
        'sat_barang',
        'jenisobat',
        'hna',
        'diskon',
        'hrgsat_barang',
        'hrgjual_barang',
        'komisi',
        'indikasi',
        'ket_barang',
        'petugas',
        'dosis',
        'waktu',
        't30',
        'q30',
    ];

    protected $casts = [
        'stok_barang'     => 'double',
        'stok_buffer'     => 'double',
        'hna'             => 'double',
        'diskon'          => 'double',
        'hrgsat_barang'   => 'double',
        'hrgjual_barang'  => 'double',
        'komisi'          => 'double',
        'waktu'           => 'datetime',
        't30'             => 'integer',
        'q30'             => 'integer',
    ];

    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class, 'jenisobat', 'jenisobat');
        // (ModelTujuan::class, foreign_key_di_produk, primary_key_di_jenis_obat)
    }
}
