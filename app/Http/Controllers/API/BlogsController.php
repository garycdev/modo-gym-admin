<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;

class BlogsController extends Controller
{
    public function blogsApp()
    {
        $blogs = Blogs::where('blog_estado', 'ACTIVO')->orderBy('blog_id', 'DESC')->get();
        return response()->json($blogs, 200);
    }
}
