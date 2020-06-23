<?php

namespace App\Imports;


use App\Models\Property;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PropertiesImport implements ToCollection, WithHeadingRow
{

    /**
     * Collection of data in a single sheet
     *
     * @param Maatwebsite\Excel\Concerns\ToCollection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $property) {

            $data = [];

            foreach ($property as $key => $value) {

                if ($key == 'suburb') {
                    $data[$key] = $value;
                } else if ($key == 'state') {
                    $data[$key] = $value;
                } else if ($key == 'country') {
                    $data[$key] = $value;
                }

            }

            if (count($data) > 0) {
                Property::create($data);
            }
        }

    }
}
