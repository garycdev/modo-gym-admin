<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $like               = new Like();
        $like->usu_login_id = $request->user()->usu_login_id;
        $like->blog_id      = $request->blog_id;
        $like->save();

        return response()->json([
            'success' => true,
            'message' => 'like',
            'data'    => $like,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $like = Like::where('usu_login_id', $request->user()->usu_login_id)->where('blog_id', $id)->first();
        if (! $like) {
            return response()->json([
                'success' => false,
                'message' => ' no dislike',
                'data'    => [],
            ], 404);
        }

        $like->delete();
        return response()->json([
            'success' => true,
            'message' => 'dislike',
            'data'    => [],
        ], 200);
    }
}
