<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin'], function () {

Route::get('/login', [App\Http\Controllers\Dashboard\HomeController::class, 'loginPage'])->middleware('adminGuest');
Route::post('/signin', [App\Http\Controllers\Dashboard\HomeController::class, 'signin'])->name('admin.login')->middleware('adminGuest');

	Route::group([ 'middleware' => 'IsAdmin'], function () {

	Route::get('/adminLogout', [App\Http\Controllers\Dashboard\HomeController::class, 'adminLogout']);

	Route::get('/dashboard', [App\Http\Controllers\Dashboard\HomeController::class, 'index']);
	Route::resource('/users',App\Http\Controllers\Dashboard\UserController::class);
	Route::resource('/roles',App\Http\Controllers\Dashboard\RolesController::class);
	Route::resource('/admins',App\Http\Controllers\Dashboard\AdminController::class);
	Route::get('/settings', [App\Http\Controllers\Dashboard\SettingController::class, 'index']);
	Route::any('/settings/{id}/update', [App\Http\Controllers\Dashboard\SettingController::class, 'update'])->name('settings.update');

	});
});