<?php

use App\Imports\PropertyAnalyticsImport;
use Illuminate\Database\Seeder;

class PropertyAnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Excel::import(new PropertyAnalyticsImport, storage_path('app/backend_data.xlsx'));
    }
}
