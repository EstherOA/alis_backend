<?php

namespace App\Http\Controllers;

use App\SpBeaconCadastral;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpBeaconCadastralController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'geom' => 'required',
            'labels' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {
            $geom = $request['geom'];
            $polygon = [];

            foreach ($geom as $point) {
                array_push($polygon, new Point($point['latitude'], $point['longitude']));
            }

            if(count($geom) == 1) {
                $polygon = $polygon[0];
            }else if(count($geom) == 2){
                $polygon = new LineString($polygon);

            } else {
                array_push($polygon, new Point($geom[0]['latitude'], $geom[0]['longitude']));
                $polygon = new LineString($polygon);
                $polygon = new Polygon([$polygon]);
            }
            logger()->debug($polygon);

            $beaconCadastral = new SpBeaconCadastral();
            $beaconCadastral->geom = $polygon;
            if($request['labels']) {
                $beaconCadastral->labels = $request['labels'];
            }
            $beaconCadastral->save();

            return response()->json([
                'message' => 'Beacon Cadastral created successfully',
                'body' => $beaconCadastral
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error creating beacon cadastral',
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $beaconCadastrals = SpBeaconCadastral::all();

        if($beaconCadastrals->count()) {

            return response()->json([
                'message' => 'Sp_Beacon_Cadastral found',
                'body' => $beaconCadastrals
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_Beacon_Cadastral not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $beaconCadastrals = SpBeaconCadastral::where('id', '=', $id);

        if($beaconCadastrals->count()) {

            return response()->json([
                'message' => 'SpBeaconCadastral found',
                'body' => $beaconCadastrals->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpBeaconCadastral not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'geom' => 'required',
            'labels' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {

            $beaconCadastral = SpBeaconCadastral::where('id', '=', $id);

            if( !$beaconCadastral->count()) {

                return response()->json([
                    'message' => 'Beacon cadastral not found',
                    'body' => []
                ], 404);
            }

            $geom = $request['geom'];
            $polygon = [];

            foreach ($geom as $point) {
                array_push($polygon, new Point($point['latitude'], $point['longitude']));
            }

            if(count($geom) == 1) {
                $polygon = $polygon[0];
            }else if(count($geom) == 2){
                $polygon = new LineString($polygon);

            } else {
                array_push($polygon, new Point($geom[0]['latitude'], $geom[0]['longitude']));
                $polygon = new LineString($polygon);
                $polygon = new Polygon([$polygon]);
            }
            logger()->debug($polygon);
            $beaconCadastral = $beaconCadastral->first();
            $beaconCadastral->geom = $polygon;
            if($request['labels']) {
                $beaconCadastral->labels = $request['labels'];
            }
            $beaconCadastral->save();

            return response()->json([
                'message' => 'Sp_Beacon_Cadastral updated successfully',
                'body' => $beaconCadastral
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
            $beaconCadastrals = SpBeaconCadastral::where('id', '=', $id);

            if(!$beaconCadastrals->count()) {

                return response()->json([
                    'message' => 'No Sp_Beacon_Cadastral found',
                    'body' => $beaconCadastrals->first()
                ], 404);

            }

            $beaconCadastrals->first()->delete();

            return response()->json([
                'message' => 'Sp_Beacon_Cadastral deleted',
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
