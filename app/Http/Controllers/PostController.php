<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::orderBy('id', 'DESC')->paginate(20);
        $pageTitle = 'All Posts';

        return view('post.list', compact('posts', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('post.form', ['post' => new Post(), 'pageTitle' => 'Create Post']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $acceptJson = $request->acceptsJson();

        $post = $request->createPost();
        if ($post && $post->exists){
            $request->session()->flash('message', ['type' => 'success', 'text' => 'Successfully posted.']);
            if ($acceptJson){
                return response()->json(['success' => true, 'redirect_to' => route('post.me')]);
            } else {
                return redirect()->intended(route('post.me'));
            }
        }

        $m = 'Posting failed.';
        if ($acceptJson){
            return response()->json([
                "errors" => [
                    "message" => $m
                ]
            ], 422);
        } else {
            return back()->withErrors([
                'message' => $m,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return redirect(route('post.view', ['slug' => $post->slug]));
    }

    public function showBySlug(string $slug)
    {
        $post = Post::where('slug', $slug)->first();
        if ( !($post && $post->exists)){
            abort(404, sprintf('Post with %s not found', $slug));
        }

        if (Auth::user()?->id != $post->user_id){
            $post->increment('views');
        }

        return view('post.show', ['post' => $post, 'pageTitle' => $post->title]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        return view('post.form', ['post' => $post, 'pageTitle' => 'Edit Post']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $acceptJson = $request->acceptsJson();
        if ($post = $request->updatePost()){
            if ($acceptJson){
                return response()->json(['success' => true, 'message' => sprintf('Successfully updated. <a href="%s">View Post</a>', route('view.post', ['slug' => $post->slug]))]);
            } else {
                return back()->with('message', ['type' => 'success', 'text' => 'Successfully updated.']);
            }
        }

        $m = 'Fail to update post.';
        if ($acceptJson){
            return response()->json([
                "errors" => [
                    "message" => $m
                ]
            ], 422);
        } else {
            return back()->withErrors([
                'message' => $m,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $acceptJson = $request->acceptsJson();
        $error = null;
        try{
            $result = $post->delete();
            if ( !$result){
                $error = 'Failed to delete.';
            }
        } catch (Exception $e){
            $error = $e->getMessage();
        }

        if ( !$error){
            $request->session()->flash('message', ['type' => 'success', 'text' => 'Successfully deleted.']);
            if ($acceptJson){
                return response()->json(['success' => true]);
            }
        }

        if ($acceptJson){
            return response()->json(['message' => $error], 422);
        }

        return back();
    }

    public function me(Request $request)
    {
        $posts = $request->user()->posts()->orderBy('id', 'DESC')->paginate(20);
        $pageTitle = 'My Posts';

        return view('post.list', compact('posts', 'pageTitle'));
    }
}
