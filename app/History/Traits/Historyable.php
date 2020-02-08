<?php

namespace App\History\Traits;

use App\History;
use Illuminate\Database\Eloquent\Model;

trait Historyable
{
    protected static function bootHistoryable()
    {
        parent::boot();

        static::updated(function (Model $model) {

        });
    }

    public function history()
    {
        return $this->morphMany(History::class, 'historyable')
            ->latest();
    }
}
