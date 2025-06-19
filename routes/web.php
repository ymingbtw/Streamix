<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('not found');
});
// Route::get('/movies/{movie}', function ($movie) {
//     return response()->file(base_path() . '/movies/' . $movie . '/index.m3u8');
// });
// Route::get('/movies/{movie}/{res}/{file}', function ($movie, $res, $file) {
//     return response()->file(
//         base_path() . '/movies/' . $movie . '/' . $res . '/' . $file
//     );
// });
