<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('tag', 'TagCrudController');
}); // this should be the absolute last line of this file

Route::group([
    'namespace'  => 'App\Http\Controllers\Form',   // edit this namespace as needed
    'middleware' => ['web', backpack_middleware()],
], function () {
    // custom admin routes
    Route::crud('fd-02-1', 'FD0201Controller');
});
