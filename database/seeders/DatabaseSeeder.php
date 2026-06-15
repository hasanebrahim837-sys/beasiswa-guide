<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\University;
use App\Models\Scholarship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $indonesia = Country::firstOrCreate(
            ['code' => 'ID'],
            ['name' => 'Indonesia']
        );

        $ui = University::firstOrCreate(
            ['name' => 'Universitas Indonesia'],
            [
                'country_id' => $indonesia->id,
                'city' => 'Depok',
                'website' => 'https://www.ui.ac.id',
                'description' => 'One of the top public universities in Indonesia.',
            ]
        );

        $ugm = University::firstOrCreate(
            ['name' => 'Universitas Gadjah Mada'],
            [
                'country_id' => $indonesia->id,
                'city' => 'Yogyakarta',
                'website' => 'https://www.ugm.ac.id',
                'description' => 'A leading public university located in Yogyakarta.',
            ]
        );

        $uinsalatiga = University::firstOrCreate(
            ['name' => 'UIN Salatiga'],
            [
                'country_id' => $indonesia->id,
                'city' => 'Salatiga',
                'website' => 'https://uinsalatiga.ac.id',
                'description' => 'State Islamic University in Salatiga.',
            ]
        );

        Scholarship::firstOrCreate(
            ['title' => 'KNB Scholarship'],
            [
                'country_id' => $indonesia->id,
                'university_id' => $ui->id,
                'degree' => 'Bachelor, Master, PhD',
                'funding_type' => 'Fully Funded',
                'open_date' => '2026-01-01',
                'deadline' => '2026-12-31',
                'official_link' => 'https://knb.kemdiktisaintek.go.id',
                'source_link' => 'https://knb.kemdiktisaintek.go.id',
                'description' => 'KNB Scholarship is an Indonesian government scholarship for international students from developing countries.',
                'eligibility' => 'International students, good academic record, valid passport, and required academic documents.',
                'required_documents' => 'Passport, academic certificate, transcript, recommendation letter, English certificate, motivation letter.',
                'is_active' => true,
            ]
        );

        Scholarship::firstOrCreate(
            ['title' => 'Darmasiswa Scholarship'],
            [
                'country_id' => $indonesia->id,
                'university_id' => $ugm->id,
                'degree' => 'Non-degree',
                'funding_type' => 'Partial Funded',
                'open_date' => '2026-05-15',
                'deadline' => '2026-06-15',
                'official_link' => 'https://darmasiswa.kemendikdasmen.go.id',
                'source_link' => 'https://darmasiswa.kemendikdasmen.go.id',
                'description' => 'Darmasiswa is a scholarship program for foreign students to study Indonesian language, arts, and culture.',
                'eligibility' => 'Foreign students interested in Indonesian language, culture, and arts.',
                'required_documents' => 'Passport, CV, academic certificate, health certificate, recommendation letter.',
                'is_active' => true,
            ]
        );

        Scholarship::firstOrCreate(
            ['title' => 'UIN Salatiga International Student Scholarship'],
            [
                'country_id' => $indonesia->id,
                'university_id' => $uinsalatiga->id,
                'degree' => 'Bachelor',
                'funding_type' => 'Partial Funded',
                'open_date' => '2026-07-01',
                'deadline' => '2026-09-30',
                'official_link' => 'https://uinsalatiga.ac.id',
                'source_link' => 'https://uinsalatiga.ac.id',
                'description' => 'A sample scholarship information for international students who want to study at UIN Salatiga.',
                'eligibility' => 'International students with complete academic documents.',
                'required_documents' => 'Passport, diploma, transcript, photo, motivation letter.',
                'is_active' => true,
            ]
        );
    }
}