<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Well;
use App\Models\DailyProduction;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Генерируем ровно 22 компании
        $companies = Company::factory()->count(22)->create();
        $allWellIds = [];

        foreach ($companies as $company) {
            // В каждой компании числится от 2 до 5 сотрудников
            Employee::factory()->count(rand(2, 5))->create([
                'company_id' => $company->id
            ]);

            // За каждой компанией закреплено от 2 до 10 буровых скважин
            $wellsCount = rand(2, 10);
            $wells = Well::factory()->count($wellsCount)->create([
                'company_id' => $company->id
            ]);

            foreach ($wells as $well) {
                $allWellIds[] = $well->id;
            }
        }

        // Выбираем строго первые 5 скважин (по ID)
        $targetWells = Well::orderBy('id', 'asc')->take(5)->get();
        $bulkData = [];
        $now = Carbon::now();

        foreach ($targetWells as $well) {
            for ($i = 0; $i < 365; $i++) {
                $bulkData[] = [
                    'well_id'          => $well->id,
                    'date'             => $now->copy()->subDays($i)->format('Y-m-d'),
                    'production_value' => rand(50, 500) + (rand(0, 99) / 100),
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];

                if (count($bulkData) >= 500) {
                    DailyProduction::insert($bulkData);
                    $bulkData = [];
                }
            }
        }

        if (!empty($bulkData)) {
            DailyProduction::insert($bulkData);
        }
    }
}
