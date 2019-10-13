<?php

namespace App\Http\Controllers;

use App\SpRegistrationDistrictBoundary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpRegistrationDistrictBoundaryController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'regioid' => 'nullable|string',
            'distriid' => 'nullable|string',
            'src_info' => 'nullable|string',
            'src_date' => 'nullable|date',
            'reg_name' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {
            $geom = $request['geom'];
            $multipart = [];

            foreach ($geom as $polygon) {
                $multi = [];
                foreach ($polygon as $point) {
                    array_push($multi, new Point($point['latitude'], $point['longitude']));
                }
                array_push($multi, new Point($polygon[0]['latitude'], $polygon[0]['longitude']));
                $multi = new LineString($multi);
                $multi = new Polygon([$multi]);
                array_push($multipart, $multi);
            }

//            if(count($geom) == 1) {
//                $multipart = $multipart[0];
//            }else if(count($geom) == 2){
//                $multipart = new LineString($multipart);
//
//            } else {
//                array_push($multipart, new Point($geom[0]['latitude'], $geom[0]['longitude']));
//                $multipart = new LineString($multipart);
//                $multipart = new Polygon([$multipart]);
//            }
            $multipart = new MultiPolygon($multipart);
            logger()->debug($multipart);

            $input = $request->all();
            $input['geom'] = $multipart;
            $spRegistrationDistrictBoundary = SpRegistrationDistrictBoundary::create($input);

            return response()->json([
                'message' => 'Sp_RegistrationDistrictBoundary created successfully',
                'body' => $spRegistrationDistrictBoundary
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $spRegistrationDistrictBoundaries = SpRegistrationDistrictBoundary::all();

        if($spRegistrationDistrictBoundaries->count()) {

            return response()->json([
                'message' => 'Sp_RegistrationDistrictBoundary found',
                'body' => $spRegistrationDistrictBoundaries
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_RegistrationDistrictBoundary not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $spRegistrationDistrictBoundaries = SpRegistrationDistrictBoundary::where('id', '=', $id);

        if($spRegistrationDistrictBoundaries->count()) {

            return response()->json([
                'message' => 'SpRegistrationDistrictBoundary found',
                'body' => $spRegistrationDistrictBoundaries->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpRegistrationDistrictBoundary not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'regioid' => 'nullable|string',
            'distriid' => 'nullable|string',
            'src_info' => 'nullable|string',
            'src_date' => 'nullable|date',
            'reg_name' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {

            $spRegistrationDistrictBoundary = SpRegistrationDistrictBoundary::where('id', '=', $id);

            if( !$spRegistrationDistrictBoundary->count()) {

                return response()->json([
                    'message' => 'Sp RegistrationDistrictBoundary not found',
                    'body' => []
                ], 404);
            }

            $geom = $request['geom'];
            $multipart = [];

            foreach ($geom as $polygon) {
                $multi = [];
                foreach ($polygon as $point) {
                    array_push($multi, new Point($point['latitude'], $point['longitude']));
                }
                array_push($multi, new Point($polygon[0]['latitude'], $polygon[0]['longitude']));
                $multi = new LineString($multi);
                $multi = new Polygon([$multi]);
                array_push($multipart, $multi);
            }

//            if(count($geom) == 1) {
//                $multipart = $multipart[0];
//            }else if(count($geom) == 2){
//                $multipart = new LineString($multipart);
//
//            } else {
//                array_push($multipart, new Point($geom[0]['latitude'], $geom[0]['longitude']));
//                $multipart = new LineString($multipart);
//                $multipart = new Polygon([$multipart]);
//            }
            $multipart = new MultiPolygon($multipart);
            logger()->debug($multipart);

            $input = $request->all();
            $input['geom'] = $multipart;
            $spRegistrationDistrictBoundary = $spRegistrationDistrictBoundary->update($input);

            return response()->json([
                'message' => 'Sp_RegistrationDistrictBoundary updated successfully',
                'body' => $spRegistrationDistrictBoundary
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 500);
        }
    }

    public function destroy($id) {

        try {
            $spRegistrationDistrictBoundaries = SpRegistrationDistrictBoundary::where('id', '=', $id);

            if(!$spRegistrationDistrictBoundaries->count()) {

                return response()->json([
                    'message' => 'No Sp_RegistrationDistrictBoundary found',
                    'body' => $spRegistrationDistrictBoundaries->first()
                ], 404);

            }

            $spRegistrationDistrictBoundaries->first()->delete();

            return response()->json([
                'message' => 'Sp_RegistrationDistrictBoundary deleted',
                'body' => []
            ], 200);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 500);
        }
    }
}
