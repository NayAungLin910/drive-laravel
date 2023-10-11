<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FileController extends Controller
{
    /**
     * User files
     */
    public function myFiles()
    {
        return Inertia::render('MyFiles');
    }

    /**
     * Create Folder
     */
    public function createFolder(StoreFolderRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;

        if (!$parent) {
            $parent = $this->getRoot();
        }

        $file = new File();
        $file->is_folder = 1;
        $file->name = $data['name'];

        $parent->appendNode($file);
    }

    /**
     * Get root folder of the current user
     */
    public function getRoot()
    {
        return File::query()->where('created_by', Auth::id())->whereIsRoot()->firstOrFail();
    }
}
