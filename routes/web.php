<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/wms/workspaces', 'WMS_setup@createWorkspace');
Route::post('/wms/workspaces/datastores', 'WMS_setup@createDatastore');
Route::post('/wms/workspaces/datastores/layers', 'WMS_setup@createLayer');
