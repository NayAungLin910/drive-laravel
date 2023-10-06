<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Adds created_by and updated_by column with the currently
 * logged in user id whenever the model get created or updated.
 */
trait HasCreatorAndUpdator
{
    protected static function bootHasCreatorAndUpdator()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
