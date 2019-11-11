<?php

namespace App\Http\Controllers;

use App\SpParcelSmd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpParcelSmdController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'ccno' => 'nullable|string',
            'ref_no' => 'nullable|string',
            'reg_no' => 'nullable|string',
            'cert_no' => 'nullable|string',
            'a_name' => 'nullable|string',
            'grantor' => 'nullable|string',
            'locality' => 'nullable|string',
            'job_number' => 'nullable|string',
            'type_instr' => 'nullable|string',
            'date_instr' => 'nullable|date',
            'considerat' => 'nullable|string',
            'purpose' => 'nullable|string',
            'date_com' => 'nullable|date',
            'term' => 'nullable|string',
            'mul_claim' => 'nullable|string',
            'remarks' => 'nullable|string',
            't_code' => 'nullable|numeric',
            'label_code' => 'nullable|numeric',
            'plotted_by' => 'nullable|string',
            'checked_by' => 'nullable|string',
            'date_plott' => 'nullable|string',
            'plan_no' => 'nullable|string',
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
            $SpParcelSmd = SpParcelSmd::create($input);

            return response()->json([
                'message' => 'Sp_ParcelSmd created successfully',
                'body' => $SpParcelSmd
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

        $SpParcelSmds = SpParcelSmd::all();

        if($SpParcelSmds->count()) {

            return response()->json([
                'message' => 'Sp_ParcelSmd found',
                'body' => $SpParcelSmds
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_ParcelSmd not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $SpParcelSmds = SpParcelSmd::where('id', '=', $id);

        if($SpParcelSmds->count()) {

            return response()->json([
                'message' => 'SpParcelSmd found',
                'body' => $SpParcelSmds->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpParcelSmd not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'ccno' => 'nullable|string',
            'ref_no' => 'nullable|string',
            'reg_no' => 'nullable|string',
            'cert_no' => 'nullable|string',
            'a_name' => 'nullable|string',
            'grantor' => 'nullable|string',
            'locality' => 'nullable|string',
            'job_number' => 'nullable|string',
            'type_instr' => 'nullable|string',
            'date_instr' => 'nullable|date',
            'considerat' => 'nullable|string',
            'purpose' => 'nullable|string',
            'date_com' => 'nullable|date',
            'term' => 'nullable|string',
            'mul_claim' => 'nullable|string',
            'remarks' => 'nullable|string',
            't_code' => 'nullable|numeric',
            'label_code' => 'nullable|numeric',
            'plotted_by' => 'nullable|string',
            'checked_by' => 'nullable|string',
            'date_plott' => 'nullable|string',
            'plan_no' => 'nullable|string',
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

            $SpParcelSmd = SpParcelSmd::where('id', '=', $id);

            if( !$SpParcelSmd->count()) {

                return response()->json([
                    'message' => 'Sp ParcelSmd not found',
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
            $SpParcelSmd = $SpParcelSmd->update($input);

            return response()->json([
                'message' => 'Sp_ParcelSmd updated successfully',
                'body' => $SpParcelSmd
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
            $SpParcelSmds = SpParcelSmd::where('id', '=', $id);

            if(!$SpParcelSmds->count()) {

                return response()->json([
                    'message' => 'No Sp_ParcelSmd found',
                    'body' => $SpParcelSmds->first()
                ], 404);

            }

            $SpParcelSmds->first()->delete();

            return response()->json([
                'message' => 'Sp_ParcelSmd deleted',
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

            $foundParcel = SpParcelSmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()]);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Smd Parcels found',
                    'body' => $foundParcel->get(),
                    'query' => $coords->toWKT()
                ], 200);
            }

            return response()->json([
                'message' => 'No Smd Parcels found',
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

            $foundParcel = SpParcelSmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$wkt])
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$wkt])
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$wkt]);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Smd Parcels found',
                    'body' => $foundParcel->get()
                ], 200);
            }

            return response()->json([
                'message' => 'No Smd Parcels found',
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

        $foundParcel = SpParcelSmd::whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
            ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
            ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()]);

        if($foundParcel->count())
            return true;
        else return false;
    }

}
