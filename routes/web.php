<?php

Route::get('/', function () {
    $user = \App\User::find(1);

    $user->history()->create([
        'changed_column' => 'name',
        'changed_value_from' => 'elijah',
        'changed_value_to' => 'elijah updated'
    ]);
});
