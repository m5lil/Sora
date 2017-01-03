<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests;

class CategoryController extends Controller
{
  public function index()
  {
      $categories = Category::all();
      return response()->json([
        'categories' => $categories,
      ]);
  }
  public function store(Request $request)
  {
      $input = $request->all();
      Category::create($input);
  }
  public function show($id)
  {
      return Category::findOrFail($id);
  }
  public function update(Request $request, $id)
  {
      $input = $request->all();
      Category::findOrFail($id)->update($input);
      // return Response::json($request->all()); //response()->json()
  }
  public function destroy($id)
  {
      return Category::destroy($id);
  }
}
