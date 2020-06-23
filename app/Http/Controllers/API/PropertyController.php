<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProperty;
use Illuminate\Support\Facades\Validator;
use App\Models\PropertyAnalytic;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "suburb" => "required|string",
            "state" => "required|string",
            "country" => "required|string"
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            return response()->json([
                'status' => 400,
                'errors' => $errors->all()
            ]);
        }

        $property = new Property;
        $property->suburb = $request->suburb;
        $property->state = $request->state;
        $property->country = $request->country;
        $property->save();

        return response()->json($property);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (preg_match('/^\d+$/',$id)) {

            $property = Property::find($id);

            if($property) {

                $new_data = clone $property;

                $new_data->load(['propertyAnalytic' => function ($query) {
                    $query->with('analytic');
                }]);

                return response()->json([
                    'status' => 200,
                    'data' => $new_data
                ]);
            }
        }


        return response()->json([
            'status' => 200,
            'message' => 'There is no record that exist with that ID.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }


     /**
     * @param Illuminate\Support\Collection $data
     * @return \Illuminate\Http\Response
     */
    private function dataCollectionNum($data){

        $summary = [];

        $analyticType = collect($data)->groupBy('name')->toArray();

        foreach($analyticType as $index => $value){

            $summary[$index] = [
                'is_numeric' => 1
            ];

            $data = collect($value)->pluck('value');

            $dataCount = $data->count();
            $dataCountArray = $data->countBy()
                                      ->toArray();

            foreach($dataCountArray as $key => $dataValue){
                $dataCountArray[$key] = (($dataValue / $dataCount) * 100) . '%';
            }

            $data = $data->sort()->values()->all();

            $summary[$index]['percentage'] = $dataCountArray;
            $summary[$index]['min_value'] = $data[0] * 1;
            $summary[$index]['max_value'] = $data[count($data) - 1] * 1;

            if(count($data) % 2 === 0){

                $mean = (count($data)) / 2;
                $summary[$index]['mean'] = ($data[$mean - 1] + $data[$mean]) / 2;

            }else{

                $mean = (count($data) - 1) / 2;
                $summary[$index]['mean'] = $data[$mean];

            }

        }
        return $summary;
    }

    /**
     * @param Illuminate\Support\Collection $data
     * @return \Illuminate\Http\Response
     */
    private function dataCollelctionNon($data){

        $summary = [];
        $analyticType = collect($data)->groupBy('name')
                                        ->toArray();

        foreach($analyticType as $index => $value){

            $summary[$index] = [];

            $valueArray = collect($value)->pluck('value');
            $dataCount = $valueArray->count();
            $dataCountArray = $valueArray->countBy()->toArray();

            foreach($dataCountArray as $key => $dataValue){
                $dataCountArray[$key] = (($dataValue / $dataCount) * 100) . '%';
            }

            $summary[$index]['percentage'] = $dataCountArray;
            $summary[$index]['is_numeric'] = 0;
            $summary[$index]['min_value'] = null;
            $summary[$index]['max_value'] = null;
            $summary[$index]['median'] = null;
        }
        return $summary;
    }

     /**
     * Get All Property Summary
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllSummary(Request $request){

        $validateRule = [
            'demography' => [
                'required',
                Rule::in(['suburb', 'state', 'country']),
            ],
            'name' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validateRule);

        if ($validator->fails()) {

            $errors = $validator->errors();

            return response()->json([
                'status' => 400,
                'errors' => $errors->all()
            ]);
        }

        $property = new PropertyAnalytic();

        $property = $property->join('properties', 'property_analytics.property_id', '=', 'properties.id')
                             ->groupBy('property_analytics.id');

        $property = $property->join('analytic_types', 'property_analytics.analytic_type_id', '=', 'analytic_types.id')
                             ->groupBy('property_analytics.id');

        $property = $property->where('properties.' . $request->demography, $request->name);

        $property2 = clone $property;
        $property2 = $property2->where('is_numeric', 0);

        $numResult = $property->where('is_numeric', 1)
                           ->get()
                           ->toArray();

        $nonNumResult = $property2->get()
                             ->toArray();

        $summary = [];
        $response = [];

        if(count($numResult)){

            $summary = $this->dataCollectionNum($numResult);

            $response = [
                'status' => 200,
                'data' => $summary
            ];

        } else if(count($nonNumResult)) {

            $summary = collect($summary)
                        ->merge($this->dataCollelctionNon($nonNumResult))
                        ->all();

            $response = [
                'status' => 200,
                'data' => $summary
            ];

        } else{

            $response = [
                'status' => 200,
                'message' => 'No record found.'
            ];
        }

        return response()->json($response);

    }

}
