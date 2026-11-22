<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Country::firstOrCreate(
            ['code' => 'ID'],
            ['name' => 'Indonesia']
        );

        // Real scholarships, checked against their official pages.
        $this->call(ScholarshipsSeeder::class);
    }
}
