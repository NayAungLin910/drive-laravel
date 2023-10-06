<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ParentIdBaseRequest extends FormRequest
{
    public ?File $parent = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // find the parent file of the currently being created file
        $this->parent = File::query()->where('id', $this->input('parent_id'))->first();

        // if parent file exists and if the current user is not the owner, returns false
        if ($this->parent && !$this->parent->isOwnedBy(Auth::id())) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                Rule::exists(File::class, 'id') // if there is parent_id it must exists in the files table inside the id column
                    ->where(function (Builder $query) {
                        return $query->where('is_folder', '=', '1') // must be folder
                            ->where('created_by', '=', Auth::id()); // the current user must be the owner of the folder
                    })
            ]
        ];
    }
}
