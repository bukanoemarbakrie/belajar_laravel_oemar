<?php

namespace Database\Seeders;

use App\Models\Peserta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert
        // Peserta::create([
        //    'name' => "Mohammad Umar Zakaria",
        //    'email' => "bukanoemarbakrie@gmail.com",
        //    "age" => 24,
        //    "address" => 'Tangerang Selatan',
        // ]);

        Peserta::factory(50)->create();
    }
}
