<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Services\CsvReader;
use App\Services\DriveService;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $csv = CsvReader::read(\Storage::drive(DriveService::PARSE)->path('property-data.csv'));
        Property::query()->truncate();

        foreach ($csv as $row) {
            Property::query()->create($row);
        }
    }
}
