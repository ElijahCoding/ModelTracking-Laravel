<?php

namespace App\History\Traits;

use App\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\History\ColumnChange;

trait Historyable
{
    protected static function bootHistoryable()
    {
        static::updated(function (Model $model) {
            dd($model->getChangedColumns($model));
        });
    }

    protected function getChangedColumns(Model $model)
    {
        return collect(
            array_diff(
                $model->getChanges(),
                $original = $model->getOriginal()
            )
        )->map(function ($change, $column) use ($original) {
            return new ColumnChange(
                $column,
                Arr::get($original, $column),
                $change
            );
        });
    }

    public function history()
    {
        return $this->morphMany(History::class, 'historyable')
            ->latest();
    }
}
