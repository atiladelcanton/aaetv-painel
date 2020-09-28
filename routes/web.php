<?php

Route::get(
    '/',
    function () {
        return redirect('/login');
    }
);

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile', ['shield' => ['usuarios.edit'], 'uses' => 'UsersController@profile'])->name('usuarios.profile');
Route::post('profile/{id}', ['shield' => ['usuarios.edit'], 'uses' => 'UsersController@updateProfile'])->name(
    'usuarios.update_profile'
);
include 'grupos/web.php';
include 'usuarios/web.php';
include 'clientes/web.php';
