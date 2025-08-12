<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_jobs')->insert([
            [
                'nama_pekerjaan' => 'Ganti Oli Mesin',
                'estimasi_waktu' => '30 menit',
                'tipe_harga'     => 'tetap',
                'harga_jual'    => 250000,
                'hpp_jasa'      => 150000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_pekerjaan' => 'Tune Up Mesin',
                'estimasi_waktu' => '2 jam',
                'tipe_harga'     => 'tetap',
                'harga_jual'    => 500000,
                'hpp_jasa'      => 300000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_pekerjaan' => 'Perbaikan Rem',
                'estimasi_waktu' => '1 jam',
                'tipe_harga'     => 'per_jam',
                'harga_jual'    => 200000,
                'hpp_jasa'      => 100000,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
