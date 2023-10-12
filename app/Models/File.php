<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory, HasCreatorAndUpdator, NodeTrait, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }

    /**
     * if the file is root folder or not
     */
    public function isRoot()
    {
        return $this->parent_id === null;
    }

    // checks if the file is created by the given user
    public function isOwnedBy($userId): bool
    {
        return $this->created_by === $userId;
    }

    protected static function boot()
    {
        parent::boot();

        // whenever a file is being create
        static::creating(function ($model) {
            if (!$model->parent) { // if no model parent or if it is root since it does not need path
                return;
            }

            $model->path = (!$model->parent->isRoot() ? // if the file is not root folder, and if the parent of the file being created is not root,
                $model->parent->path . '/' : // then prefix the folder with the parent folder path
                ''
            ) . Str::slug($model->name);
        });
    }
}
