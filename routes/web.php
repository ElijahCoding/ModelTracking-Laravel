<?php

Route::get('/', function () {
    $user = \App\User::find(1);

    $user->history()->create([

    ]);
});
