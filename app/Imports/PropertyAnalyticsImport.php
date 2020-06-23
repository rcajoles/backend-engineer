<?php

namespace App\Imports;

use App\Models\PropertyAnalytic;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PropertyAnalyticsImport implements ToCollection, WithHeadingRow
{
    /**
     * Collection of data in a single sheet
     *
     * @param Maatwebsite\Excel\Concerns\ToCollection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $propertyAnalytic) {

            $data = [];

            foreach ($propertyAnalytic as $key => $value) {

                if ($key == 'property_id' && $value) {
                    $data[$key] = $value;
                } else if ($key == 'analytic_type_id' && $value) {
                    $data[$key] = $value;
                    // dd($key, $value);
                } else if ($key == 'value' && $value) {
                    $data[$key] = $value;
                }

            }

            if (count($data) > 0) {
                PropertyAnalytic::create($data);
            }
        }
    }
}
