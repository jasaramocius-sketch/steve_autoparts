<?php

namespace App\Traits;

trait TracksIsDeleted
{
    protected static function bootTracksIsDeleted()
    {
        static::deleted(function ($model) {
            if (!$model->isForceDeleting()) {
                $model->updateQuietly([
                    'is_deleted' => 1,
                ]);
            }
        });

        static::restored(function ($model) {
            $model->updateQuietly([
                'is_deleted' => 0,
            ]);
        });
    }
}