<?php

Route::namespace('Root')->prefix('admin')->name('root.')->group(function () {
    Route::namespace('Auth')->name('auth.')->group(function() {
        Route::middleware('guest', 'throttle:60,1')->group(function () {
            Route::get('signin', 'SessionsController@showSigninForm')->name('signin');
            Route::post('signin', 'SessionsController@signin');

            Route::prefix('password')->name('password.')->group(function() {
                Route::get('request', 'ForgotPasswordController@showLinkRequestForm')->name('request');
                Route::post('request', 'ForgotPasswordController@sendResetLinkEmail');

                Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
                Route::post('reset/{token}', 'ResetPasswordController@reset');

                Route::get('set/{token}', 'SetPasswordController@showSetForm')->name('set');
                Route::post('set/{token}', 'SetPasswordController@set');
            });

            Route::prefix('verify')->name('verify.')->group(function() {
                Route::get('/', 'AccountVerificationController@showVerificationForm')->name('request');
                Route::post('/', 'AccountVerificationController@sendVerificationLink');

                Route::get('{token}', 'AccountVerificationController@check')->name('check');
            });
        });

        Route::any('signout', 'SessionsController@signout')->middleware('auth')->name('signout');
    });

    Route::middleware('auth', 'throttle:60,1')->group(function () {
        Route::prefix('account')->name('account.')->group(function() {
            Route::get('profile', 'AccountController@profile')->name('profile');
            Route::get('password', 'AccountController@password')->name('password');
            Route::patch('profile', 'AccountController@updateProfile')->name('profile.update');
            Route::patch('password', 'AccountController@updatePassword')->name('password.update');
        });

        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::resource('admins', 'AdminsController');
        Route::resource('elections', 'ElectionsController');
        Route::resource('candidates', 'CandidatesController');
        Route::resource('users', 'UsersController');
        Route::get('users/{user}/control-numbers', 'UsersController@showControlNumbers')->name('users.control-numbers');

        Route::prefix('elections/{election}')->name('elections.')->group(function() {
            Route::name('positions.')->group(function() {
                Route::get('positions', 'ElectionsController@setPositions')->name('set');
                Route::patch('positions', 'ElectionsController@updatePositions')->name('update');
            });

            Route::name('candidates.')->group(function() {
                Route::get('candidates', 'ElectionsController@nominee')->name('set');
                Route::post('candidates', 'ElectionsController@nominate')->name('nominate');
            });

            Route::get('tally', 'ElectionsController@tally')->name('tally');
        });

        Route::resource('positions', 'PositionsController');
        Route::resource('grades', 'GradesController');
        Route::resource('sections','SectionsController');
    });
});