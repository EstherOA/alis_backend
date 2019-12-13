<?php

namespace App\Http\Controllers;

use App\SpBeaconSmd;
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\SpBeaconSmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\MultiPoint;
use Phaza\LaravelPostgis\Geometries\Point;

class SpBeaconSmdController extends Controller
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

            $beaconSmd = new SpBeaconSmd();
            $beaconSmd->geom = $multipart;
            if($request['label']) {
                $beaconSmd->label = $request['label'];
            }
            $beaconSmd->save();

            return response()->json([
                'message' => 'Beacon Smd created successfully',
                'body' => $beaconSmd
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error creating beacon smd',
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $beaconSmds = SpBeaconSmd::all();

        if($beaconSmds->count()) {

            return response()->json([
                'message' => 'Sp_Beacon_Smd found',
                'body' => $beaconSmds
            ], 200);

        }

        return response()->json([
            'message' => 'No Sp_Beacon_Smd found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $beaconSmds = SpBeaconSmd::where('id', '=', $id);

        if($beaconSmds->count()) {

            return response()->json([
                'message' => 'SpBeaconSmd found',
                'body' => $beaconSmds->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpBeaconSmd not found',
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

            $beaconSmd = SpBeaconSmd::where('id', '=', $id);

            if( !$beaconSmd->count()) {

                return response()->json([
                    'message' => 'Beacon Smd not found',
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
            $beaconSmd = $beaconSmd->first();
            $beaconSmd->geom = $multipart;
            if($request['label']) {
                $beaconSmd->label = $request['label'];
            }
            $beaconSmd->save();

            return response()->json([
                'message' => 'Sp_Beacon_Smd updated successfully',
                'body' => $beaconSmd
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
            $beaconSmds = SpBeaconSmd::where('id', '=', $id);

            if(!$beaconSmds->count()) {

                return response()->json([
                    'message' => 'No Sp_Beacon_Smd found',
                    'body' => $beaconSmds->first()
                ], 404);

            }

            $beaconSmds->first()->delete();

            return response()->json([
                'message' => 'Sp_Beacon_Smd deleted',
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
