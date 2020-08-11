<?
Route::get('/', 'taskController@index');
Route::post('/', 'taskController@update');

Route::get('/auth', 'authController@index');
Route::post('/auth', 'authController@auth');
Route::get('/logout', 'authController@logout');