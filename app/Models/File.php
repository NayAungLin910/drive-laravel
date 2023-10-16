<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
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

    public function owner(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['created_by'] == Auth::id() ? 'me' :
                    $this->user->name;
            },
        );
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
            if (!$model->parent) { // if the file is root folder, returns since it does not require a path
                return;
            }

            // if the parent of the file being created is not root,
            $model->path = (!$model->parent->isRoot() ?
                // then prefix the folder with the parent folder's path
                $model->parent->path . '/' :
                ''
            ) . Str::slug($model->name);
        });
    }
}
