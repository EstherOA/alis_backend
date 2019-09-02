<?php

namespace App\Http\Controllers\API;

use App\SpDistrict;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPoint;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpDistrictController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'dist_numb' => 'nullable|string'
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
            $spDistrict = SpDistrict::create($input);

            return response()->json([
                'message' => 'Sp District created successfully',
                'body' => $spDistrict
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error creating Sp District',
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $spDistricts = SpDistrict::all();

        if($spDistricts->count()) {

            return response()->json([
                'message' => 'Sp_District found',
                'body' => $spDistricts
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_District not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $spDistricts = SpDistrict::where('id', '=', $id);

        if($spDistricts->count()) {

            return response()->json([
                'message' => 'SpDistrict found',
                'body' => $spDistricts->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpDistrict not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'object_id' => 'nullable|numeric',
            'shape_leng' => 'nullable|numeric',
            'shape_area' => 'nullable|numeric',
            'dist_numb' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {

            $spDistrict = SpDistrict::where('id', '=', $id);

            if( !$spDistrict->count()) {

                return response()->json([
                    'message' => 'Sp District not found',
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
            $spDistrict = $spDistrict->update($input);

            return response()->json([
                'message' => 'Sp_District updated successfully',
                'body' => $spDistrict
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
            $spDistricts = SpDistrict::where('id', '=', $id);

            if(!$spDistricts->count()) {

                return response()->json([
                    'message' => 'No Sp_District found',
                    'body' => $spDistricts->first()
                ], 404);

            }

            $spDistricts->first()->delete();

            return response()->json([
                'message' => 'Sp_District deleted',
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
