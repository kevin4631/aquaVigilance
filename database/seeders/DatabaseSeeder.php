<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursEau;
use App\Models\Region;
use App\Models\RegionCoursEau;
use App\Models\Conseil;
use App\Models\ConseilCourEau;
use SplFileObject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $regionFile = new SplFileObject(database_path('../public/data/BDD/region2020.csv'));
        $regionFile->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);

        foreach ($regionFile as $row) {
            if (!empty($row[0]) && !empty($row[1])) {
                Region::create([
                    "code_region" => $row[0],
                    "libelle" => $row[1]
                ]);
            }
        }

        $coursEauFile = new SplFileObject(database_path('../public/data/BDD/cours_eau.csv'));
        $coursEauFile->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);

        foreach ($coursEauFile as $row) {
            if (!empty($row[0]) && !empty($row[1])) {
                CoursEau::create([
                    "code_cours_eau" => $row[0],
                    "libelle" => $row[1]
                ]);
            }
        }

        $RegionCoursEau = new SplFileObject(database_path('../public/data/BDD/regions_coursEau.csv'));
        $RegionCoursEau->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);

        foreach ($RegionCoursEau as $row) {
            if (!empty($row[0]) && !empty($row[1])) {
                RegionCoursEau::create([
                    "code_region" => $row[0],
                    "code_cours_eau" => $row[1]
                ]);
            }
        }

        $Conseils = new SplFileObject(database_path('../public/data/BDD/fichier_conseils_eau.csv'));
        $Conseils->setFlags(SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);

        foreach ($Conseils as $row) {
            if (!empty($row[0]) && !empty($row[1])) {
                Conseil::create([
                    "code_cours_eau" => $row[0],
                    "description" => $row[1]
                ]);
            }
        }
        
    }
}
