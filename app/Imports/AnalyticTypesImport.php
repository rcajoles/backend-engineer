<?php

namespace App\Imports;

use App\Models\AnalyticType;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnalyticTypesImport implements ToCollection, WithHeadingRow
{
    /**
     * Collection of data in a single sheet
     *
     * @param Maatwebsite\Excel\Concerns\ToCollection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $analyticType) {

            $data = [];

            foreach ($analyticType as $key => $value) {

                if ($key == 'name') {
                    $data[$key] = $value;
                } else if ($key == 'units') {
                    $data[$key] = $value;
                } else if ($key == 'is_numeric') {
                    $data[$key] = $value;
                } else if ($key == 'num_decimal_places') {
                    $data[$key] = $value;
                }

            }

            if (count($data) > 0) {
                AnalyticType::create($data);
            }
        }
    }
}
