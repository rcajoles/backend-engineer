<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProperty;
use Illuminate\Support\Facades\Validator;

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
}
