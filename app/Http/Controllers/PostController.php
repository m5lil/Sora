<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests;

class PostController extends Controller
{
  public function index()
  {
      $posts = Post::all();
      return response()->json([
        'posts' => $posts,
      ]);
  }
  public function store(Request $request)
  {
      $input = $request->all();
      Post::create($input);
  }
  public function show($id)
  {
      return Post::findOrFail($id);
  }
  public function update(Request $request, $id)
  {
      $input = $request->all();
      Post::findOrFail($id)->update($input);
      // return Response::json($request->all()); //response()->json()
  }
  public function destroy($id)
  {
      return Post::destroy($id);
  }
}
