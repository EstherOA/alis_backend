<?php

namespace App\Http\Controllers;

use App\SpRegistrationBlockBoundary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpRegistrationBlockBoundaryController extends Controller
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
            'blockid' => 'nullable|string',
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
            $spRegistrationBlockBoundary = SpRegistrationBlockBoundary::create($input);

            return response()->json([
                'message' => 'Sp_RegistrationBlockBoundary created successfully',
                'body' => $spRegistrationBlockBoundary
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

        $spRegistrationBlockBoundaries = SpRegistrationBlockBoundary::all();

        if($spRegistrationBlockBoundaries->count()) {

            return response()->json([
                'message' => 'Sp_RegistrationBlockBoundary found',
                'body' => $spRegistrationBlockBoundaries
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_RegistrationBlockBoundary not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $spRegistrationBlockBoundaries = SpRegistrationBlockBoundary::where('id', '=', $id);

        if($spRegistrationBlockBoundaries->count()) {

            return response()->json([
                'message' => 'SpRegistrationBlockBoundary found',
                'body' => $spRegistrationBlockBoundaries->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpRegistrationBlockBoundary not found',
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
            'blockid' => 'nullable|string',
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

            $spRegistrationBlockBoundary = SpRegistrationBlockBoundary::where('id', '=', $id);

            if( !$spRegistrationBlockBoundary->count()) {

                return response()->json([
                    'message' => 'Sp RegistrationBlockBoundary not found',
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
            $spRegistrationBlockBoundary = $spRegistrationBlockBoundary->update($input);

            return response()->json([
                'message' => 'Sp_RegistrationBlockBoundary updated successfully',
                'body' => $spRegistrationBlockBoundary
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
            $spRegistrationBlockBoundaries = SpRegistrationBlockBoundary::where('id', '=', $id);

            if(!$spRegistrationBlockBoundaries->count()) {

                return response()->json([
                    'message' => 'No Sp_RegistrationBlockBoundary found',
                    'body' => $spRegistrationBlockBoundaries->first()
                ], 404);

            }

            $spRegistrationBlockBoundaries->first()->delete();

            return response()->json([
                'message' => 'Sp_RegistrationBlockBoundary deleted',
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
