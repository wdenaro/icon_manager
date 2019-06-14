<?php



// SPLASH PAGE
Route::get('/', 'MainController@index')
    ->name('splash');


// SPLASH PAGE
// user is submitting a SKU
Route::post('manual_sku', 'MainController@manual_sku')
    ->name('manual_sku');


// SPLASH PAGE
// gather data about unprocessed SKUs and choose the next available SKU for the user
Route::get('next_available', 'MainController@next_available')
    ->name('next_available');




// WORK ZONE
// requires a hash_id, because user intent is to work on an image
Route::get('work_zone/{hash_id}', 'MainController@work_zone')
    ->name('work_zone');


// WORK ZONE
// passes all telemetry to controller for processing
Route::post('save_and_create', 'MainController@save_and_create')
    ->name('save_and_create');














Route::any('main', function () {
    return view('main');
});


// takes-in SKU and returns all available images, and presents the working_canvas
Route::post('validate_sku', 'MainController@validate_sku')
    ->name('validate_sku');



// shows the results of creating an image
Route::get('images', function() {
    return view('images');
})->name('images');















Route::get('gather/{sku?}', 'MainController@gather')
    ->name('gather');








Route::get('image_test/{rotate?}/{left?}/{top?}', 'MainController@image_test')
    ->name('image_test');



Route::get('test', 'MainController@test')
    ->name('test');