<?php

namespace App\Http\Controllers;

use App\SpRegistrationSectorBoundary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpRegistrationSectorBoundaryController extends Controller
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
            'sectioid' => 'nullable|string',
            'loc_name' => 'nullable|string',
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
            $SpRegistrationSectorBoundary = SpRegistrationSectorBoundary::create($input);

            return response()->json([
                'message' => 'Sp_RegistrationSectorBoundary created successfully',
                'body' => $SpRegistrationSectorBoundary
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

        $spRegistrationSectorBoundaries = SpRegistrationSectorBoundary::all();

        if($spRegistrationSectorBoundaries->count()) {

            return response()->json([
                'message' => 'Sp_RegistrationSectorBoundary found',
                'body' => $spRegistrationSectorBoundaries
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_RegistrationSectorBoundary not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $spRegistrationSectorBoundaries = SpRegistrationSectorBoundary::where('id', '=', $id);

        if($spRegistrationSectorBoundaries->count()) {

            return response()->json([
                'message' => 'SpRegistrationSectorBoundary found',
                'body' => $spRegistrationSectorBoundaries->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpRegistrationSectorBoundary not found',
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
            'sectioid' => 'nullable|string',
            'loc_name' => 'nullable|string',
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

            $SpRegistrationSectorBoundary = SpRegistrationSectorBoundary::where('id', '=', $id);

            if( !$SpRegistrationSectorBoundary->count()) {

                return response()->json([
                    'message' => 'Sp RegistrationSectorBoundary not found',
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
            $SpRegistrationSectorBoundary = $SpRegistrationSectorBoundary->update($input);

            return response()->json([
                'message' => 'Sp_RegistrationSectorBoundary updated successfully',
                'body' => $SpRegistrationSectorBoundary
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
            $spRegistrationSectorBoundaries = SpRegistrationSectorBoundary::where('id', '=', $id);

            if(!$spRegistrationSectorBoundaries->count()) {

                return response()->json([
                    'message' => 'No Sp_RegistrationSectorBoundary found',
                    'body' => $spRegistrationSectorBoundaries->first()
                ], 404);

            }

            $spRegistrationSectorBoundaries->first()->delete();

            return response()->json([
                'message' => 'Sp_RegistrationSectorBoundary deleted',
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
