<?php

namespace App\Http\Requests;

use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFolderRequest extends ParentIdBaseRequest
{

    /**
     * The authorization of this request is handled in the
     * extended ParentIdBaseRequest 
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required',
                Rule::unique(File::class, 'name')
                    ->where('created_by', Auth::id()) // unique only for current user
                    ->where('parent_id', $this->parent->id) // only under the current parent directory
                    ->whereNull('deleted_at') // only not deleted
            ]
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.unique' => 'Folder ":input" already exists'
        ];
    }
}
