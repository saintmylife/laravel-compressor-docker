<?php

Route::prefix('compressors')->group(function () {
    //     // Route::put('/{id}/edit', 'Update\AuthUpdateAction')->name('auth.update');
    //     Route::get('/me', 'Profile\AuthProfileAction')->middleware('jwt.verify')->name('auth.profile');
    Route::post('/multiple', 'MultipleCreate\CompressorMultipleCreateAction')->name('multiple.compressor.create');
    Route::post('/', 'Create\CompressorCreateAction')->name('compressor.create');
    Route::post('/bulk', 'CreateBulk\CompressorCreateBulkAction')->name('compressor.create.bulk');
    //     Route::post('/logout', 'Logout\AuthLogoutAction')->middleware('jwt.verify')->name('auth.logout');
});
