<?php

namespace App\Http\Controllers\API;

use App\SpRegionalBoundary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpRegionalBoundaryController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'regioid' => 'nullable|numeric',
            'src_info' => 'nullable|numeric',
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
            $SpRegionalBoundary = SpRegionalBoundary::create($input);

            return response()->json([
                'message' => 'Sp_RegionalBoundary created successfully',
                'body' => $SpRegionalBoundary
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

        $SpRegionalBoundarys = SpRegionalBoundary::all();

        if($SpRegionalBoundarys->count()) {

            return response()->json([
                'message' => 'Sp_RegionalBoundary found',
                'body' => $SpRegionalBoundarys
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_RegionalBoundary not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $SpRegionalBoundarys = SpRegionalBoundary::where('id', '=', $id);

        if($SpRegionalBoundarys->count()) {

            return response()->json([
                'message' => 'SpRegionalBoundary found',
                'body' => $SpRegionalBoundarys->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpRegionalBoundary not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'regioid' => 'nullable|numeric',
            'src_info' => 'nullable|numeric',
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

            $SpRegionalBoundary = SpRegionalBoundary::where('id', '=', $id);

            if( !$SpRegionalBoundary->count()) {

                return response()->json([
                    'message' => 'Sp RegionalBoundary not found',
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
            $SpRegionalBoundary = $SpRegionalBoundary->update($input);

            return response()->json([
                'message' => 'Sp_RegionalBoundary updated successfully',
                'body' => $SpRegionalBoundary
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
            $SpRegionalBoundarys = SpRegionalBoundary::where('id', '=', $id);

            if(!$SpRegionalBoundarys->count()) {

                return response()->json([
                    'message' => 'No Sp_RegionalBoundary found',
                    'body' => $SpRegionalBoundarys->first()
                ], 404);

            }

            $SpRegionalBoundarys->first()->delete();

            return response()->json([
                'message' => 'Sp_RegionalBoundary deleted',
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
