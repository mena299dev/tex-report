<?php
Route::group([
    'namespace'  => 'App\Http\Controllers\Admin',   // edit this namespace as needed
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    // custom admin routes
    Route::crud('user', 'UserCrudController');
});
