<?php

Route::prefix('clientes')->middleware('needsPermission')->group(
    function () {
        Route::get('/', ['shield' => ['clientes.index'], 'uses' => 'ClientController@index'])->name('clientes');
        Route::get('/criar', ['shield' => ['clientes.create'], 'uses' => 'ClientController@create'])->name(
            'clientes.create'
        );
        Route::post('/criar', ['shield' => ['clientes.create'], 'uses' => 'ClientController@store'])->name(
            'clientes.registrar'
        );
        Route::get('/editar/{id}', ['shield' => ['clientes.edit'], 'uses' => 'ClientController@edit'])->name(
            'clientes.editar'
        );
        Route::get('/{id}', ['shield' => ['clientes.show'], 'uses' => 'ClientController@show'])->name(
            'clientes.show'
        );
        Route::post('/editar/{id}', ['shield' => ['clientes.edit'], 'uses' => 'ClientController@update'])->name(
            'clientes.alterar'
        );
        Route::post('/confirm-payment', ['shield' => ['clientes.edit'], 'uses' => 'ClientController@confirmPayment'])->name(
            'clientes.confirmPayment'
        );
        Route::delete('/{id}', ['shield' => ['clientes.destroy'], 'uses' => 'ClientController@destroy'])->name(
            'clientes.deletar'
        );
    }
);
