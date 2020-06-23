<?php

use App\Imports\AnalyticTypesImport;
use Illuminate\Database\Seeder;

class AnalyticTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Excel::import(new AnalyticTypesImport, storage_path('app/backend_data.xlsx'));
    }
}
