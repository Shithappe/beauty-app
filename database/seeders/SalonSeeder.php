<?php

namespace Database\Seeders;
use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        factory(Salon::class, 10)->create();
    }
}
