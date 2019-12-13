<?php

namespace App\Http\Controllers;

use App\SpCadastral;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\Polygon;

class SpCadastralController extends Controller
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
            'date_instr' => 'nullable|string',
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
            $input = $request->all();
            $input['geom'] = $polygon;
            $cadastral =  SpCadastral::create($input);

            return response()->json([
                'message' => 'Cadastral created successfully',
                'body' => $cadastral
            ], 200);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error creating Cadastral',
                'body' => []
            ], 500);
        }
    }

    public function index() {

        $cadastrals = SpCadastral::all();

        if($cadastrals->count()) {

            return response()->json([
                'message' => 'Sp_Cadastral found',
                'body' => $cadastrals
            ], 200);

        }

        return response()->json([
            'message' => 'Sp_Cadastral not found',
            'body' => []
        ], 400);
    }

    public function read($id) {

        $cadastrals = SpCadastral::where('id', '=', $id);

        if($cadastrals->count()) {

            return response()->json([
                'message' => 'SpCadastral found',
                'body' => $cadastrals->first()
            ], 200);

        }

        return response()->json([
            'message' => 'SpCadastral not found',
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
            'date_instr' => 'nullable|string',
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

            $cadastral = SpCadastral::where('id', '=', $id);

            if( !$cadastral->count()) {

                return response()->json([
                    'message' => 'Cadastral not found',
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
//            $polygon = new MultiPoint($polygon);
            logger()->debug($polygon);
            $input = $request->all();
            $input['geom'] = $polygon;
            $cadastral = $cadastral->first()->update($input);

            return response()->json([
                'message' => 'Sp_Cadastral updated successfully',
                'body' => $cadastral
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
            $cadastrals = SpCadastral::where('id', '=', $id);

            if(!$cadastrals->count()) {

                return response()->json([
                    'message' => 'No Sp_Cadastral found',
                    'body' => $cadastrals->first()
                ], 404);

            }

            $cadastrals->first()->delete();

            return response()->json([
                'message' => 'Sp_Cadastral deleted',
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
