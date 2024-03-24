<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursEau;
use App\Models\Region;
use SplFileObject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $file = new SplFileObject(database_path('../public/data/BDD/cours_eau.csv' , '../public/data/region2020.csv'));
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);

        foreach ($file as $row) {
            if (!empty($row[0]) && !empty($row[1])) {
                CoursEau::create([
                    "code_cours_eau" => $row[0],
                    "libelle" => $row[1]
                ]);
                Region::create([
                    "code_region" => $row[0],
                    "libelle" => $row[1]
                ]);
            }
        }
    }
}
