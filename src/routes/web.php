<?php

Route::group(['middleware' => ['web'], 'namespace' => '\NAdminPanel\Blog\Controllers'], function () {

    Route::group(['middleware' => ['auth', 'admin'], 'prefix' => config('nadminpanel.admin_backend_prefix')], function () {

        Route::get('category/archive', 'CategoryController@indexArchive')->name('category.archive');
        Route::delete('category/archive/{archive}', 'CategoryController@destroyArchive')->name('category.archive.delete');
        Route::match(['put', 'patch'], 'category/archive/{archive}', 'CategoryController@unarchive')->name('category.archive.unarchive');

        Route::resource('category', 'CategoryController');

    });

});

