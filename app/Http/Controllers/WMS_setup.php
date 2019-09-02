<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class WMS_setup extends Controller
{
    //create workspace, datastore, addlayers,
    const BASE_URI = 'http://127.0.0.1:8080/geoserver/rest/';

    function createWorkspace(Request $request) {

        $workspace_uri = 'workspaces';

        $validator = Validator::make($request->all() , [

            'name' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all()
            ], 400);
        }

        try {
            $client = new Client([
                'base_uri' => self::BASE_URI,
            ]);

            $response = $client->request('POST', $workspace_uri, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'workspace' => [
                        'name' => $request['name']
                    ]
                ],
                'auth' => ['admin', 'geoserver']
            ]);
            $status = $response->getStatusCode();
            logger()->debug($status);

            if($status == 201 || $status == 200 ) {
                return response()->json([
                    'message' => 'Workspace created successfully',
                    'body' => (string) $response->getBody()
                ], 201);
            }

            return response()->json([
                'message' => 'Workspace creation failed',
                'body' => (string) $response->getBody()
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 400);
        }
    }

    function createDatastore(Request $request) {

        $validator = Validator::make($request->all() , [

            'workspaceName' => 'required|string',
            'datastoreName' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all()
            ], 400);
        }

        $datastore_uri = 'workspaces/' . $request['workspaceName'] . '/datastores';

        try {

            $client = new Client([
                'base_uri' => self::BASE_URI,
            ]);

            $response = $client->request('POST', $datastore_uri, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'dataStore' => [
                        'name' => $request['datastoreName'],
                        'connectionParameters' => [
                            'entry' => [
                                ['@key' => 'host', '$' => 'localhost'],
                                ['@key' => 'port', '$' => '5432'],
                                ['@key' => 'database', '$' => 'gelisgh_db_new'],
                                ['@key' => 'user', '$' => 'postgres'],
                                ['@key' => 'passwd', '$' => 'root123'],
                                ['@key' => 'dbtype', '$' => 'postgis'],
                            ]
                        ]
                    ]
                ],
                'auth' => ['admin', 'geoserver']
            ]);
            $status = $response->getStatusCode();
            logger()->debug($status);

            if($status == 201 || $status == 200 ) {
                return response()->json([
                    'message' => 'Datastore created successfully',
                    'body' => (string) $response->getBody()
                ], 201);
            }

            return response()->json([
                'message' => 'Datastore creation failed',
                'body' => (string) $response->getBody()
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 400);
        }
    }

    public function createLayer(Request $request) {

        $validator = Validator::make($request->all() , [

            'workspaceName' => 'required|string',
            'datastoreName' => 'required|string',
            'featureName' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all()
            ], 400);
        }

        $datastore_uri = 'workspaces/' . $request['workspaceName'] . '/datastores/' . $request['datastoreName'] . '/featuretypes';

        try {

            $client = new Client([
                'base_uri' => self::BASE_URI,
            ]);

            $response = $client->request('POST', $datastore_uri, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'featureType' => [
                        'name' => $request['featureName']
                    ]
                ],
                'auth' => ['admin', 'geoserver']
            ]);
            $status = $response->getStatusCode();
            logger()->debug($status);

            if($status == 201 || $status == 200 ) {
                return response()->json([
                    'message' => 'Layer created successfully',
                    'body' => (string) $response->getBody()
                ], 201);
            }

            return response()->json([
                'message' => 'Layer creation failed',
                'body' => (string) $response->getBody()
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'body' => []
            ], 400);
        }
    }
}
