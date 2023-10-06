<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class File extends Model
{
    use HasFactory, HasCreatorAndUpdator, NodeTrait, SoftDeletes;

    // checks if the file is created by the given user
    public function isOwnedBy($userId): bool
    {
        return $this->created_by === $userId;
    }
}
