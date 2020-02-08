<?php

use App\User;

Route::get('/', function () {
    $user = \App\User::find(1);

    $user->update([
        'name' => 'something'
    ]);
});


Route::get('/users/{user}/history', function (User $user) {
    return view('users.history', [
        'histories' => $user->history
    ]);
});
