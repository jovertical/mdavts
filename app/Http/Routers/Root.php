<?php

Route::namespace('Root')->prefix('admin')->name('root.')->group(function () {
    Route::namespace('Auth')->name('auth.')->group(function() {
        Route::middleware('guest')->group(function () {
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

    Route::middleware('auth')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::resources([
            'admins' => 'AdminsController',
            'users' => 'UsersController',

            'elections' => 'ElectionsController',
            'candidates' => 'CandidatesController',
            'positions' => 'PositionsController',

            'grades' => 'GradesController',
            'sections' => 'SectionsController',
        ]);

        Route::get('users/{user}/control-numbers', 'UsersController@showControlNumbers')->name('users.control-numbers');

        Route::prefix('elections/{election}')->name('elections.')->group(function() {
            Route::get('dashboard', 'ElectionDashboardController@showDashboardPage')->name('dashboard');

            Route::get('control-numbers', 'ElectionControlNumbersController@showControlNumbersPage')->name('control-numbers');
            Route::post('control-numbers', 'ElectionControlNumbersController@store');

            Route::get('positions', 'ElectionPositionsController@showPositionsPage')->name('positions');
            Route::post('positions', 'ElectionPositionsController@store');

            Route::get('candidates', 'ElectionCandidatesController@showCandidatesPage')->name('candidates');
            Route::post('candidates', 'ElectionCandidatesController@store');

            Route::get('tally', 'ElectionTallyController@showTallyPage')->name('tally');
            Route::post('tally', 'ElectionTallyController@export');
        });

        Route::prefix('system')->name('system.')->group(function() {
            Route::get('settings', 'SettingsController@showSettingsPage')->name('settings');
            Route::post('settings', 'SettingsController@update');
        });

        Route::prefix('account')->name('account.')->group(function() {
            Route::get('profile', 'AccountController@profile')->name('profile');
            Route::get('password', 'AccountController@password')->name('password');
            Route::patch('profile', 'AccountController@updateProfile')->name('profile.update');
            Route::patch('password', 'AccountController@updatePassword')->name('password.update');
        });
    });
});