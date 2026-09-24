<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KompetensiSeeder::class,
            KelasSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            BeritaSeeder::class,
            GaleriSeeder::class,
            PrestasiSeeder::class,
            AgendaSeeder::class,
            StatistikSeeder::class,
            MenuNavigasiSeeder::class,
            HeroSliderSeeder::class,
        ]);
    }
}