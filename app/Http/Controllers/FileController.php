<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Http\Resources\FileResource;
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
        $folder = $this->getRoot(); // get root folder of the current user

        $files = File::query()
            ->where('parent_id', $folder->id)
            ->where('created_by', Auth::id())
            ->orderBy('is_folder', 'desc')
            ->orderBY('created_at', 'desc')
            ->paginate(10);

        $files = FileResource::collection($files);

        return Inertia::render('MyFiles', compact('files'));
    }

    /**
     * Create Folder
     */
    public function createFolder(StoreFolderRequest $request)
    {

        // dd(File::where('created_by', Auth::id())->where('parent_id', 1)->whereNull('deleted_at')->get());

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
