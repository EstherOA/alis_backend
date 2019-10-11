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

Route::post('sp-beacon-cadastrals', 'API\SpBeaconCadastralController@store'); //Fixme add auth middleware
Route::get('sp-beacon-cadastrals', 'API\SpBeaconCadastralController@index'); //Fixme add auth middleware
Route::get('sp-beacon-cadastrals/{id}', 'API\SpBeaconCadastralController@read'); //Fixme add auth middleware
Route::post('sp-beacon-cadastrals/{id}', 'API\SpBeaconCadastralController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-cadastrals/{id}', 'API\SpBeaconCadastralController@destroy'); //Fixme add auth middleware

Route::post('sp-beacon-lrd', 'API\SpBeaconLrdController@store'); //Fixme add auth middleware
Route::get('sp-beacon-lrd', 'API\SpBeaconLrdController@index'); //Fixme add auth middleware
Route::get('sp-beacon-lrd/{id}', 'API\SpBeaconLrdController@read'); //Fixme add auth middleware
Route::post('sp-beacon-lrd/{id}', 'API\SpBeaconLrdController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-lrd/{id}', 'API\SpBeaconLrdController@destroy'); //Fixme add auth middleware

Route::post('sp-beacon-smd', 'API\SpBeaconSmdController@store'); //Fixme add auth middleware
Route::get('sp-beacon-smd', 'API\SpBeaconSmdController@index'); //Fixme add auth middleware
Route::get('sp-beacon-smd/{id}', 'API\SpBeaconSmdController@read'); //Fixme add auth middleware
Route::post('sp-beacon-smd/{id}', 'API\SpBeaconSmdController@update'); //Fixme add auth middleware
Route::delete('sp-beacon-smd/{id}', 'API\SpBeaconSmdController@destroy'); //Fixme add auth middleware

Route::post('sp-cadastral', 'API\SpCadastralController@store'); //Fixme add auth middleware
Route::get('sp-cadastral', 'API\SpCadastralController@index'); //Fixme add auth middleware
Route::get('sp-cadastral/{id}', 'API\SpCadastralController@read'); //Fixme add auth middleware
Route::post('sp-cadastral/{id}', 'API\SpCadastralController@update'); //Fixme add auth middleware
Route::delete('sp-cadastral/{id}', 'API\SpCadastralController@destroy'); //Fixme add auth middleware

Route::post('sp-district', 'API\SpDistrictController@store'); //Fixme add auth middleware
Route::get('sp-district', 'API\SpDistrictController@index'); //Fixme add auth middleware
Route::get('sp-district/{id}', 'API\SpDistrictController@read'); //Fixme add auth middleware
Route::post('sp-district/{id}', 'API\SpDistrictController@update'); //Fixme add auth middleware
Route::delete('sp-district/{id}', 'API\SpDistrictController@destroy'); //Fixme add auth middleware

Route::post('sp-parcel-lrd', 'API\SpParcelLrdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-lrd', 'API\SpParcelLrdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-lrd/{id}', 'API\SpParcelLrdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-lrd/{id}', 'API\SpParcelLrdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-lrd/{id}', 'API\SpParcelLrdController@destroy'); //Fixme add auth middleware
Route::post('search-lrd', 'API\SpParcelLrdController@findParcelByCoordinates'); //Fixme add auth middleware

Route::post('sp-parcel-pvlmd', 'API\SpParcelPvlmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd', 'API\SpParcelPvlmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@destroy'); //Fixme add auth middleware
Route::post('search-pvlmd', 'API\SpParcelPvlmdController@findParcelByCoordinates'); //Fixme add auth middleware

Route::post('sp-parcel-smd', 'API\SpParcelSmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-smd', 'API\SpParcelSmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-smd/{id}', 'API\SpParcelSmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-smd/{id}', 'API\SpParcelSmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-smd/{id}', 'API\SpParcelSmdController@destroy'); //Fixme add auth middleware
Route::post('search-smd', 'API\SpParcelSmdController@findParcelByCoordinates'); //Fixme add auth middleware

Route::post('sp-regional-boundary', 'API\SpRegionalBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-regional-boundary', 'API\SpRegionalBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-regional-boundary/{id}', 'API\SpRegionalBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-regional-boundary/{id}', 'API\SpRegionalBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-regional-boundary/{id}', 'API\SpRegionalBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-block-boundary', 'API\SpRegistrationBlockBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-block-boundary', 'API\SpRegistrationBlockBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-block-boundary/{id}', 'API\SpRegistrationBlockBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-block-boundary/{id}', 'API\SpRegistrationBlockBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-block-boundary/{id}', 'API\SpRegistrationBlockBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-district-boundary', 'API\SpRegistrationDistrictBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-district-boundary', 'API\SpRegistrationDistrictBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-district-boundary/{id}', 'API\SpRegistrationDistrictBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-district-boundary/{id}', 'API\SpRegistrationDistrictBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-district-boundary/{id}', 'API\SpRegistrationDistrictBoundaryController@destroy'); //Fixme add auth middleware

Route::post('sp-registration-sector-boundary', 'API\SpRegistrationSectorBoundaryController@store'); //Fixme add auth middleware
Route::get('sp-registration-sector-boundary', 'API\SpRegistrationSectorBoundaryController@index'); //Fixme add auth middleware
Route::get('sp-registration-sector-boundary/{id}', 'API\SpRegistrationSectorBoundaryController@read'); //Fixme add auth middleware
Route::post('sp-registration-sector-boundary/{id}', 'API\SpRegistrationSectorBoundaryController@update'); //Fixme add auth middleware
Route::delete('sp-registration-sector-boundary/{id}', 'API\SpRegistrationSectorBoundaryController@destroy'); //Fixme add auth middleware

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

Route::get('email/activate/{token}', 'RegistrationController@emailVerification');

Route::any('/{id}', function(){
    return response()->json(['message' => "resource not found", 'data' => []],404);
});