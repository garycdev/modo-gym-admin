<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;

class BlogsController extends Controller
{
    public function blogsApp()
    {
        $blogs = Blogs::all();
        return response()->json($blogs, 200);
    }
}
