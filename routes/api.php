<?php

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

/**
 * List all pet's owners.
 */
Route::get('/pet_owner/list', 'PetOwnerController@list_all');

/**
 * List all selected owner's pets.
 */
Route::get('/pet_owner/{id}/list_pets', 'PetOwnerController@list_pets');

/**
 * Create a new owner.
 */
Route::post('/pet_owner/create', 'PetOwnerController@create');

/**
 * Modify a pet owner information.
 */
Route::put('/pet_owner/{id}/modify', 'PetOwnerController@modify');

/**
 * Create a new pet
 */
Route::post('/pet/create', 'PetController@create');

/**
 * Delete a pet.
 */
Route::delete('/pet/{id}/delete', 'PetController@delete');