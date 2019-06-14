<?php

use Illuminate\Http\Request;

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

// List Contacts
Route::get('contacts', 'ContactController@index');

// List Single Contact
Route::get('contact/{id}', 'ContactController@show');

// Create new Contact
Route::post('contact', 'ContactController@store');

// Update Contact
Route::put('contact', 'ContactController@store');

// Delete Contact
Route::delete('contact/{id}', 'ContactController@destroy');

// List Groups
Route::get('groups', 'GroupController@index');

// Create new Group
Route::post('group', 'GroupController@store');

// Update Group
Route::put('group', 'GroupController@store');

// Delete Group
Route::delete('group/{id}', 'GroupController@destroy');