<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use App\Imports\PropertiesImport;
use App\Imports\AnalyticTypesImport;
use App\Imports\PropertyAnalyticsImport;

class DataImport implements WithMultipleSheets
{
    /**
    * @param void
    * @return void
    */
    public function sheets(): array
    {
        return [
           0 => new PropertiesImport(),
           1 => new AnalyticTypesImport(),
           2 => new PropertyAnalyticsImport()
        ];
    }

}
