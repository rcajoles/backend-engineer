<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PropertyAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyAnalyticController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (preg_match('/^\d+$/',$id)) {

            $propAnalytic = PropertyAnalytic::find($id);

            if($propAnalytic) {

                $new_data = clone $propAnalytic;

                $new_data->load('property', 'analytic');

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (preg_match('/^\d+$/', $id)) {

            $validator = Validator::make($request->all(), [
                "property_id" => "required|exists:properties,id|integer",
                "analytic_type_id" => "required|exists:analytic_types,id|integer",
                "value" => "required|string",
            ]);

            if ($validator->fails()) {

                $errors = $validator->errors();

                return response()->json([
                    'status' => 400,
                    'errors' => $errors->all()
                ]);
            }

            $propAnalytic = PropertyAnalytic::find($id);

            if($propAnalytic) {

                if ($request->has('property_id')) {
                    $propAnalytic->property_id = $request->property_id;
                }

                if ($request->has('analytic_type_id')) {
                    $propAnalytic->analytic_type_id = $request->analytic_type_id;
                }

                if ($request->has('value')) {
                    $propAnalytic->value = $request->value;
                }

                $propAnalytic->save();

                return response()->json([
                    'status' => 200,
                    'data'  => $propAnalytic,
                    'message' => 'Successfully Updated Property Analytic Record'
                ]);
            }

        }

        return response()->json([
            'status' => 200,
            'message' => 'There is no record that exist with that ID.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAnalytic $propertyAnalytic)
    {
        //
    }
}
