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
            collect($model->getChangedColumns($model))->each(function ($change) use ($model) {
                $model->saveChange($change);
            });
        });
    }

    protected function saveChange(ColumnChange $change)
    {
        $this->history()->create([
            'changed_column' => $change->column,
            'changed_value_from' => $change->from,
            'changed_value_to' => $change->to,
        ]);
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
