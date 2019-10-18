<?php
use App\User;
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
Route::group(['prefix' => 'backoffice'], function () {
    Route::get('/', 'DashboardController@index')->middleware('auth');
    Route::resource('users', 'UserController');
    Route::resource('parties', 'PartyController');
    Route::resource('referenda', 'ReferendumController');
    Route::resource('elections', 'ElectionController');
    Route::resource('groups', 'GroupController');
    Route::patch('election/{election}/candidate/{candidate}/approve',[
        'as' => 'candidate.approve',
        'uses' => 'CandidateController@approve'
    ]);
    Route::patch('election/{election}/candidate/{candidate}/unapprove',[
        'as' => 'candidate.unapprove',
        'uses' => 'CandidateController@unapprove'
    ]);
    Route::get('/settings', function () {
        return view('settings');
    });
    Auth::routes();
});

Route::group([
    'middleware' => [
        'auth',
    ],
    'name' => 'verify',
    'as' => 'verify.'
], function () {
    Route::get('/verify', 'VerifyController@index')->name('index');
    Route::post('/verify', 'VerifyController@check')->name('check');
});

//Auth::routes();

//Route::get('/', 'DashboardController@index')->middleware('auth');
//Route::resource('users', 'UserController');
//Route::resource('parties', 'PartyController');
//Route::resource('referenda', 'ReferendumController');
//Route::resource('elections', 'ElectionController');
//Route::resource('groups', 'GroupController');




Route::get('/', 'HomeController@index')->middleware('auth');
