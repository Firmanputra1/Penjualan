<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'tanggal_penjualan',
        'jumlah',
        'harga',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'jumlah' => 'integer',
        'harga' => 'decimal:2',
    ];

    /**
     * Get total penjualan (jumlah * harga)
     */
    public function getTotalAttribute()
    {
        return $this->jumlah * $this->harga;
    }
}

