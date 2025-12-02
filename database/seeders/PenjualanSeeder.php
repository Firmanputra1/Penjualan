<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama_produk' => 'Produk A',
                'tanggal_penjualan' => '2025-01-01',
                'jumlah' => 2,
                'harga' => 50000,
            ],
            [
                'nama_produk' => 'Produk B',
                'tanggal_penjualan' => '2025-01-02',
                'jumlah' => 1,
                'harga' => 75000,
            ],
            [
                'nama_produk' => 'Produk C',
                'tanggal_penjualan' => '2025-01-03',
                'jumlah' => 2,
                'harga' => 60000,
            ],
            [
                'nama_produk' => 'Produk D',
                'tanggal_penjualan' => '2025-01-02',
                'jumlah' => 2,
                'harga' => 61000,
            ],
            [
                'nama_produk' => 'Produk E',
                'tanggal_penjualan' => '2025-01-04',
                'jumlah' => 1,
                'harga' => 25000,
            ],
        ];

        foreach ($data as $item) {
            Penjualan::create($item);
        }
    }
}

