<?php

Route::get('/', function () {
    $user = \App\User::find(1);

    $user->update([
        'name' => 'elijah'
    ]);
});
