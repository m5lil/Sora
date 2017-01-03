<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests;

class CommentController extends Controller
{
  public function index()
  {
      $comments = Comment::all();
      return response()->json([
        'comments' => $comments,
      ]);
  }
  public function store(Request $request)
  {
      $input = $request->all();
      Comment::create($input);
  }
  public function show($id)
  {
      return Comment::findOrFail($id);
  }
  public function update(Request $request, $id)
  {
      $input = $request->all();
      Comment::findOrFail($id)->update($input);
      // return Response::json($request->all()); //response()->json()
  }
  public function destroy($id)
  {
      return Comment::destroy($id);
  }
}
