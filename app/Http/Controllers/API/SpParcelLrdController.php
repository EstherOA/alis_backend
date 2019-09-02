<?php

namespace App\Http\Controllers\API;

use App\SpParcelLrd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\MultiPolygon;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpParcelLrdController extends Controller
{
    //
    public function store(Request $request) {

        //validate request data
        $validator = Validator::make($request->all(), [

            'cc_numb' => 'nullable|string',
            'ref_no' => 'nullable|string',
            'reg_no' => 'nullable|string',
            'cert_no' => 'nullable|string',
            'a_name' => 'nullable|string',
            'grantor' => 'nullable|string',
            'locality' => 'nullable|string',
            'job_number' => 'nullable|string',
            'type_instr' => 'nullable|string',
            'date_ins' => 'nullable|string',
            'considerat' => 'nullable|string',
            'purpose' => 'nullable|string',
            'date_com' => 'nullable|string',
            'term' => 'nullable|string',
            'mul_claim' => 'nullable|string',
            'remarks' => 'nullable|string',
            't_code' => 'nullable|string',
            'label_code' => 'nullable|string',
            'plotted_by' => 'nullable|string',
            'checked_by' => 'nullable|string',
            'plott_date' => 'nullable|string',
            'area' => 'nullable|numeric',
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
            $SpParcelLrd = SpParcelLrd::create($input);

            return response()->json([
                'message' => 'Sp_ParcelLrd created successfully',
                'body' => $SpParcelLrd
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

        $SpParcelLrds = SpParcelLrd::selectRaw('id, cc_numb, ref_no, reg_no, cert_no, a_name, grantor,
            locality, job_number, type_instr, date_ins, considerat, purpose, date_com, term, mul_claim,
            remarks, t_code, label_code, plotted_by, checked_by, plott_date, area, ST_AsText(geom), source,
            created_at, updated_at');

        if($SpParcelLrds->count()) {

            return response()->json([
                'message' => 'Sp_ParcelLrd found',
                'body' => $SpParcelLrds->get()
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_ParcelLrd not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $SpParcelLrds = SpParcelLrd::where('id', '=', $id);

        if($SpParcelLrds->count()) {

            return response()->json([
                'message' => 'SpParcelLrd found',
                'body' => $SpParcelLrds->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpParcelLrd not found',
            'body' => []
        ], 400);

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [

            'cc_numb' => 'nullable|string',
            'ref_no' => 'nullable|string',
            'reg_no' => 'nullable|string',
            'cert_no' => 'nullable|string',
            'a_name' => 'nullable|string',
            'grantor' => 'nullable|string',
            'locality' => 'nullable|string',
            'job_number' => 'nullable|string',
            'type_instr' => 'nullable|string',
            'date_ins' => 'nullable|string',
            'considerat' => 'nullable|string',
            'purpose' => 'nullable|string',
            'date_com' => 'nullable|string',
            'term' => 'nullable|string',
            'mul_claim' => 'nullable|string',
            'remarks' => 'nullable|string',
            't_code' => 'nullable|string',
            'label_code' => 'nullable|string',
            'plotted_by' => 'nullable|string',
            'checked_by' => 'nullable|string',
            'plott_date' => 'nullable|string',
            'area' => 'nullable|numeric',
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

            $SpParcelLrd = SpParcelLrd::where('id', '=', $id);

            if( !$SpParcelLrd->count()) {

                return response()->json([
                    'message' => 'Sp ParcelLrd not found',
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
            $SpParcelLrd = $SpParcelLrd->update($input);

            return response()->json([
                'message' => 'Sp_ParcelLrd updated successfully',
                'body' => $SpParcelLrd
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
            $SpParcelLrds = SpParcelLrd::where('id', '=', $id);

            if(!$SpParcelLrds->count()) {

                return response()->json([
                    'message' => 'No Sp_ParcelLrd found',
                    'body' => $SpParcelLrds->first()
                ], 404);

            }

            $SpParcelLrds->first()->delete();

            return response()->json([
                'message' => 'Sp_ParcelLrd deleted',
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

            $foundParcel = SpParcelLrd::select('id', 'geom')->whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()])
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', [$coords->toWKT()]);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Lrd Parcels found',
                    'body' => [
                        'data' => $foundParcel->get(),
                        'type' => 'LRD'
                    ]
                ], 200);
            }

            return response()->json([
                'message' => 'No Lrd Parcels found',
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

    public function wktSearch(Request $request) {

        try {
            $wkt = $request['wkt'];

            logger()->debug($wkt);

            $foundParcel = SpParcelLrd::select('id', 'geom')->whereRaw('ST_Contains(geom, ST_GeomFromText(?, 3857))', $wkt)
                ->orWhereRaw('ST_Overlaps(geom, ST_GeomFromText(?, 3857))', $wkt)
                ->orWhereRaw('ST_Intersects(geom, ST_GeomFromText(?, 3857))', $wkt);

            if($foundParcel->count()) {
                return response()->json([
                    'message' => 'Lrd Parcels found',
                    'body' => [
                        'data' => $foundParcel->get(),
                        'type' => 'LRD'
                    ]
                ], 200);
            }

            return response()->json([
                'message' => 'No Lrd Parcels found',
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
}
