<?php

use Illuminate\Support\Facades\Route;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function () {

        /////////////////////////////////////////////////////////////////////////////////////////

        Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin','prefix' => 'admin'], function () {
            Route::get('login','LoginController@login')-> name('admin.login');
            Route::post('login','LoginController@postLogin')-> name('admin.post.login');
        
        });

        /////////////////////////////////////////////////////////////////////////////////////////


        Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
            Route::get('/','DashboardController@index')-> name('dashboard');
            Route::get('logout','LoginController@logout')->name('admin.logout');
        
            // Setting Route
            Route::group(['prefix' => 'settings'], function () {
                Route::get('shipping-methods/{type}' , 'SettingsController@editShippingMethods')->name('edit.shipping.methods');
                Route::put('shipping-methods/{id}' , 'SettingsController@updateShippingMethods')->name('update.shipping.methods');
            });

              // Profile Route
              Route::group(['prefix' => 'profile'], function () {
                Route::get('edit' , 'ProfileController@editProfile')->name('edit.profile');
                Route::put('update' , 'ProfileController@updateProfile')->name('update.profile');
                Route::put('update-password' , 'ProfileController@updatePassword')->name('update.password');
            });

            // Category Route
            Route::group(['prefix' => 'main_categories'], function () {
                Route::get('/', 'MainCategoriesController@index')->name('admin.main_categories');
                Route::get('create', 'MainCategoriesController@create')->name('admin.main_categories.create');
                Route::post('store', 'MainCategoriesController@store')->name('admin.main_categories.store');
                Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.main_categories.edit');
                Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.main_categories.update');
                Route::get('delete/{id}', 'MainCategoriesController@destroy')->name('admin.main_categories.delete');
            });
        });
        
    
});

