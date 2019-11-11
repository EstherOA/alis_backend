<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['auth:api', 'roles']
], function () {
    Route::get('logout', 'SessionsController@logout');
});
Route::get('email/activate/{token}', 'RegistrationController@emailVerification');
Route::post('login', 'SessionsController@login');
Route::post('register', 'RegistrationController@store');


Route::group([
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create')->middleware('auth:api');
    Route::post('reset', 'PasswordResetController@reset')->middleware('auth:api');
    Route::get('find/{token}', 'PasswordResetController@find');
});

Route::post('sp-beacon-cadastrals', 'SpBeaconCadastralController@store'); //Fixme add auth middleware
Route::get('sp-beacon-cadastrals', 'SpBeaconCadastralController@index'); //Fixme add auth middleware
Route::get('sp-beacon-cadastrals/{id}', 'SpBeaconCadastralController@read'); //Fixme add auth middleware
Route::post('sp-beacon-cadastrals/{id}', 'SpBeaconCadastralController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-cadastrals/{id}', 'SpBeaconCadastralController@destroy'); //Fixme add auth middleware

Route::post('sp-beacon-lrd', 'SpBeaconLrdController@store'); //Fixme add auth middleware
Route::get('sp-beacon-lrd', 'SpBeaconLrdController@index'); //Fixme add auth middleware
Route::get('sp-beacon-lrd/{id}', 'SpBeaconLrdController@read'); //Fixme add auth middleware
Route::post('sp-beacon-lrd/{id}', 'SpBeaconLrdController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-lrd/{id}', 'SpBeaconLrdController@destroy'); //Fixme add auth middleware

Route::post('sp-beacon-smd', 'SpBeaconSmdController@store'); //Fixme add auth middleware
Route::get('sp-beacon-smd', 'SpBeaconSmdController@index'); //Fixme add auth middleware
Route::get('sp-beacon-smd/{id}', 'SpBeaconSmdController@read'); //Fixme add auth middleware
Route::post('sp-beacon-smd/{id}', 'SpBeaconSmdController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-smd/{id}', 'SpBeaconSmdController@destroy'); //Fixme add auth middleware

Route::post('sp-cadastral', 'SpCadastralController@store'); //Fixme add auth middleware
Route::get('sp-cadastral', 'SpCadastralController@index'); //Fixme add auth middleware
Route::get('sp-cadastral/{id}', 'SpCadastralController@read'); //Fixme add auth middleware
Route::post('sp-cadastral/{id}', 'SpCadastralController@update'); //Fixme add auth middleware
Route::delete('sp-cadastral/{id}', 'SpCadastralController@destroy'); //Fixme add auth middleware

Route::post('sp-district', 'SpDistrictController@store'); //Fixme add auth middleware
Route::get('sp-district', 'SpDistrictController@index'); //Fixme add auth middleware
Route::get('sp-district/{id}', 'SpDistrictController@read'); //Fixme add auth middleware
Route::post('sp-district/{id}', 'SpDistrictController@update'); //Fixme add auth middleware
Route::delete('sp-district/{id}', 'SpDistrictController@destroy'); //Fixme add auth middleware

Route::post('sp-parcel-lrd', 'SpParcelLrdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-lrd', 'SpParcelLrdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-lrd/{id}', 'SpParcelLrdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-lrd/{id}', 'SpParcelLrdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-lrd/{id}', 'SpParcelLrdController@destroy'); //Fixme add auth middleware
Route::post('search-lrd', 'SpParcelLrdController@findParcelByCoordinates'); //Fixme add auth middleware
Route::post('search-lrd/wkt', 'SpParcelLrdController@wktSearch'); //Fixme add auth middleware

Route::post('sp-parcel-pvlmd', 'SpParcelPvlmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd', 'SpParcelPvlmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd/{id}', 'SpParcelPvlmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-pvlmd/{id}', 'SpParcelPvlmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-pvlmd/{id}', 'SpParcelPvlmdController@destroy'); //Fixme add auth middleware
Route::post('search-pvlmd', 'SpParcelPvlmdController@findParcelByCoordinates'); //Fixme add auth middleware
Route::post('search-pvlmd/wkt', 'SpParcelPvlmdController@wktSearch'); //Fixme add auth middleware

Route::post('sp-parcel-smd', 'SpParcelSmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-smd', 'SpParcelSmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-smd/{id}', 'SpParcelSmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-smd/{id}', 'SpParcelSmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-smd/{id}', 'SpParcelSmdController@destroy'); //Fixme add auth middleware
Route::post('search-smd', 'SpParcelSmdController@findParcelByCoordinates'); //Fixme add auth middleware
Route::post('search-smd/wkt', 'SpParcelSmdController@wktSearch'); //Fixme add auth middleware

Route::post('sp-regional-boundary', 'SpRegionalBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-regional-boundary', 'SpRegionalBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-regional-boundary/{id}', 'SpRegionalBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-regional-boundary/{id}', 'SpRegionalBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-regional-boundary/{id}', 'SpRegionalBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-block-boundary', 'SpRegistrationBlockBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-block-boundary', 'SpRegistrationBlockBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-block-boundary/{id}', 'SpRegistrationBlockBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-block-boundary/{id}', 'SpRegistrationBlockBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-block-boundary/{id}', 'SpRegistrationBlockBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-district-boundary', 'SpRegistrationDistrictBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-district-boundary', 'SpRegistrationDistrictBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-district-boundary/{id}', 'SpRegistrationDistrictBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-district-boundary/{id}', 'SpRegistrationDistrictBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-district-boundary/{id}', 'SpRegistrationDistrictBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-sector-boundary', 'SpRegistrationSectorBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-sector-boundary', 'SpRegistrationSectorBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-sector-boundary/{id}', 'SpRegistrationSectorBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-sector-boundary/{id}', 'SpRegistrationSectorBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-sector-boundary/{id}', 'SpRegistrationSectorBoundaryController@destroy'); //Fixme add auth middleware

Route::get('/business-processes', 'BusinessProcessController@index');
Route::post('/business-processes', 'BusinessProcessController@store');
Route::get('/business-processes/{id}', 'BusinessProcessController@show')->where('id', '[0-9]+');
Route::put('/business-processes/{id}', 'BusinessProcessController@update')->where('id', '[0-9]+');
Route::delete('/business-processes/{id}', 'BusinessProcessController@destroy')->where('id', '[0-9]+');
Route::get('/business-processes/pending', 'BusinessProcessController@index_pending');


Route::get('/business-sub-processes', 'BusinessSubProcessController@index');
Route::post('/business-sub-processes', 'BusinessSubProcessController@store');
Route::get('/business-sub-processes/{id}', 'BusinessSubProcessController@show')->where('id', '[0-9]+');
Route::put('/business-sub-processes/{id}', 'BusinessSubProcessController@update')->where('id', '[0-9]+');
Route::delete('/business-sub-processes/{id}', 'BusinessSubProcessController@destroy')->where('id', '[0-9]+');

Route::get('/business-processes-fees', 'BusinessProcessFeeController@index');
Route::post('/business-processes-fees', 'BusinessProcessFeeController@store');
Route::get('/business-processes-fees/{id}', 'BusinessProcessFeeController@show')->where('id', '[0-9]+');
Route::put('/business-processes-fees/{id}', 'BusinessProcessFeeController@update')->where('id', '[0-9]+');
Route::delete('/business-processes-fees/{id}', 'BusinessProcessFeeController@destroy')->where('id', '[0-9]+');

Route::get('/business-processes-checklists', 'BusinessProcessChecklistController@index');
Route::post('/business-processes-checklists', 'BusinessProcessChecklistController@store');
Route::get('/business-processes-checklists/{id}', 'BusinessProcessChecklistController@show')->where('id', '[0-9]+');
Route::put('/business-processes-checklists/{id}', 'BusinessProcessChecklistController@update')->where('id', '[0-9]+');
Route::delete('/business-processes-checklists/{id}', 'BusinessProcessChecklistController@destroy')->where('id', '[0-9]+');

Route::get('/pending-applications', 'LrdPendingApplicationController@index');
Route::post('/pending-applications', 'LrdPendingApplicationController@store');

Route::post('/applications', 'LrdApplicationController@store');

Route::get('/bills','PaymentBillController@index');
Route::post('/bills', 'PaymentBillController@store');

Route::get('/documents', 'DocumentController@index');
Route::post('/documents', 'DocumentController@store');


Route::any('/{id}', function(){
    return response()->json(['message' => "resource not found", 'data' => []],404);
});