<?php

namespace App\Http\Controllers;

use App\SpBeaconLrd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPoint;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpBeaconLrdController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'label' => 'nullable|string'
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

            foreach ($geom as $point) {
                array_push($multipart, new Point($point['latitude'], $point['longitude']));
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
            $multipart = new MultiPoint($multipart);
            logger()->debug($multipart);

            $beaconLrd = new SpBeaconLrd();
            $beaconLrd->geom = $multipart;
            if($request['label']) {
                $beaconLrd->label = $request['label'];
            }
            $beaconLrd->save();

            return response()->json([
                'message' => 'Beacon Lrd created successfully',
                'body' => $beaconLrd
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error creating beacon lrd',
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $beaconLrds = SpBeaconLrd::all();

        if($beaconLrds->count()) {

            return response()->json([
                'message' => 'Sp_Beacon_Lrd found',
                'body' => $beaconLrds
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_Beacon_Lrd not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $beaconLrds = SpBeaconLrd::where('id', '=', $id);

        if($beaconLrds->count()) {

            return response()->json([
                'message' => 'SpBeaconLrd found',
                'body' => $beaconLrds->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpBeaconLrd not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'geom' => 'nullable',
            'label' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {

            $beaconLrd = SpBeaconLrd::where('id', '=', $id);

            if( !$beaconLrd->count()) {

                return response()->json([
                    'message' => 'Beacon Lrd not found',
                    'body' => []
                ], 404);
            }

            $geom = $request['geom'];
            $multipart = [];

            foreach ($geom as $point) {
                array_push($multipart, new Point($point['latitude'], $point['longitude']));
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
            $multipart = new MultiPoint($multipart);
            logger()->debug($multipart);
            $beaconLrd = $beaconLrd->first();
            $beaconLrd->geom = $multipart;
            if($request['label']) {
                $beaconLrd->label = $request['label'];
            }
            $beaconLrd->save();

            return response()->json([
                'message' => 'Sp_Beacon_Lrd updated successfully',
                'body' => $beaconLrd
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
            $beaconLrds = SpBeaconLrd::where('id', '=', $id);

            if(!$beaconLrds->count()) {

                return response()->json([
                    'message' => 'No Sp_Beacon_Lrd found',
                    'body' => $beaconLrds->first()
                ], 404);

            }

            $beaconLrds->first()->delete();

            return response()->json([
                'message' => 'Sp_Beacon_Lrd deleted',
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
