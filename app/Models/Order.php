<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $table = "order_online";
    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
        'tipe_layanan',
        'layanan_pengiriman',
        'tipe_pembayaran',
        'total_berat',
        'alamat',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // sesuaikan jika nama foreign key ber
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
