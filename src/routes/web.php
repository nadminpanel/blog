<?php


Route::group([

    'middleware' => ['web', 'auth', 'admin'],
    'prefix' => config('nadminpanel.admin_backend_prefix'),
    'namespace' => '\NAdminPanel\Blog\Controllers'

], function () {

    $modules = ['tag', 'category', 'post'];

    foreach ($modules as $module) {

        Route::get($module.'/archive', ucfirst($module).'Controller@indexArchive')->name($module.'.archive');
        Route::delete($module.'/archive/{archive}', ucfirst($module).'Controller@destroyArchive')->name($module.'.archive.delete');
        Route::match(['put', 'patch'], $module.'archive/{archive}', ucfirst($module).'Controller@unarchive')->name($module.'.archive.unarchive');
        Route::resource($module, ucfirst($module).'Controller', ['except' => ['show']]);
    }

});
