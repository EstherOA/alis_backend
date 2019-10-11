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
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
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
Route::post('search-lrd/wkt', 'API\SpParcelLrdController@wktSearch'); //Fixme add auth middleware

Route::post('sp-parcel-pvlmd', 'API\SpParcelPvlmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd', 'API\SpParcelPvlmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-pvlmd/{id}', 'API\SpParcelPvlmdController@destroy'); //Fixme add auth middleware
Route::post('search-pvlmd', 'API\SpParcelPvlmdController@findParcelByCoordinates'); //Fixme add auth middleware
Route::post('search-pvlmd/wkt', 'API\SpParcelPvlmdController@wktSearch'); //Fixme add auth middleware

Route::post('sp-parcel-smd', 'API\SpParcelSmdController@store'); //Fixme add auth middleware
Route::get('sp-parcel-smd', 'API\SpParcelSmdController@index'); //Fixme add auth middleware
Route::get('sp-parcel-smd/{id}', 'API\SpParcelSmdController@read'); //Fixme add auth middleware
Route::post('sp-parcel-smd/{id}', 'API\SpParcelSmdController@update'); //Fixme add auth middleware
Route::delete('sp-parcel-smd/{id}', 'API\SpParcelSmdController@destroy'); //Fixme add auth middleware
Route::post('search-smd', 'API\SpParcelSmdController@findParcelByCoordinates'); //Fixme add auth middleware
Route::post('search-smd/wkt', 'API\SpParcelSmdController@wktSearch'); //Fixme add auth middleware

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

Route::get('email/activate/{token}', 'RegistrationController@emailVerification');