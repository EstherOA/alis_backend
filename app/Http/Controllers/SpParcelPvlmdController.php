<?php

namespace App\Http\Controllers;

use App\SpParcelLrd;
use App\SpParcelPvlmd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpParcelPvlmdController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'src_info' => 'nullable|numeric',
            'src_date' => 'nullable|string',
            'pvlmdid' => 'nullable|string',
            'remarks' => 'nullable|string',
            'map_numb' => 'nullable|string',
            'la_tenure' => 'nullable|numeric',
            'source' => 'nullable|string',
            'geom' => 'nullable',
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

            if($this->overlaps($multi)) {

                return response()->json([
                    'message' => 'Polygon overlaps existing parcels',
                    'body' => [],
                ], 400);
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
            $SpParcelPvlmd = SpParcelPvlmd::create($input);

            return response()->json([
                'message' => 'Sp_ParcelPvlmd created successfully',
                'body' => $SpParcelPvlmd
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

        $spParcelPvlmds = SpParcelPvlmd::all();

        if($spParcelPvlmds->count()) {

            return response()->json([
                'message' => 'Sp_ParcelPvlmd found',
                'body' => $spParcelPvlmds
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_ParcelPvlmd not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $spParcelPvlmds = SpParcelPvlmd::where('id', '=', $id);

        if($spParcelPvlmds->count()) {

            return response()->json([
                'message' => 'SpParcelPvlmd found',
                'body' => $spParcelPvlmds->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpParcelPvlmd not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'src_info' => 'nullable|numeric',
            'src_date' => 'nullable|string',
            'pvlmdid' => 'nullable|string',
            'remarks' => 'nullable|string',
            'map_numb' => 'nullable|string',
            'la_tenure' => 'nullable|numeric',
            'source' => 'nullable|string',
            'geom' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all(),
            ], 400);
        }

        try {

            $SpParcelPvlmd = SpParcelPvlmd::where('id', '=', $id);

            if( !$SpParcelPvlmd->count()) {

                return response()->json([
                    'message' => 'Sp ParcelPvlmd not found',
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
            $SpParcelPvlmd = $SpParcelPvlmd->update($input);

            return response()->json([
                'message' => 'Sp_ParcelPvlmd updated successfully',
                'body' => $SpParcelPvlmd
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
            $spParcelPvlmds = SpParcelPvlmd::where('id', '=', $id);

            if(!$spParcelPvlmds->count()) {

                return response()->json([
                    'message' => 'No Sp_ParcelPvlmd found',
                    'body' => $spParcelPvlmds->first()
                ], 404);

            }

            $spParcelPvlmds->first()->delete();

            return response()->json([
                'message' => 'Sp_ParcelPvlmd deleted',
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

    public function findParcelByCoordinates(Request $request) {

        logger()->debug('In search method');

        try {
            $geom = $request['geom'];
            $coords = [];

            foreach ($geom as $point) {
                array_push($coords, new Point($point['latitude'], $point['longitude']));
            }

            if(count($geom) == 1) {
                $coords = $coords[0];
            }else if(count($geom) == 2){
                $coords = new LineString($coords);

            } else {
                array_push($coords, new Point($geom[0]['latitude'], $geom[0]['longitude']));
                $coords = new LineString($coords);
                $coords = new Polygon([$coords]);
            }
            logger()->debug($coords->toWKT());

            $foundParcel = SpParcelPvlmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()]);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Pvlmd Parcels found',
                    'body' => $foundParcel->get(),
                    'query' => $coords->toWKT()
                ], 200);
            }

            return response()->json([
                'message' => 'No Pvlmd Parcels found',
                'body' => [],
                'query' => $coords->toWKT()
            ], 404);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'body' => [],
                'query' => $coords->toWKT()
            ], 500);
        }

    }

    public function wktSearch(Request $request) {

        try {
            $wkt = $request['wkt'];

            logger()->debug($wkt);

            $foundParcel = SpParcelPvlmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$wkt])
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$wkt])
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$wkt]);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Pvlmd Parcels found',
                    'body' => $foundParcel->get()
                ], 200);
            }

            return response()->json([
                'message' => 'No Pvlmd Parcels found',
                'body' => []
            ], 404);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 500);
        }
    }

    public function overlaps($coords) {

        $foundParcel = SpParcelPvlmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
            ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
            ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()]);

        if($foundParcel->count())
            return true;
        else return false;
    }

}
