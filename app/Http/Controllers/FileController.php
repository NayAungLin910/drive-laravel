<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
