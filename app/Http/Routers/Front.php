<?php

Route::namespace('Front')->name('front.')->group(function () {
    Route::get('/', 'PagesController@welcome');
});