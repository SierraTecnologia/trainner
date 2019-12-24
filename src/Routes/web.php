<?php

Route::group(['middleware' => ['web']], function () {

    Route::prefix('trainner')->group(function () {
        Route::group(['as' => 'trainner.'], function () {

            Route::get('home', 'HomeController@index')->name('home');
            
        });
    });

});