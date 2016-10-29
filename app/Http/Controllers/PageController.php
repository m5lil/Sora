<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Http\Requests;

class PageController extends Controller
{
  public function index()
  {
      $pages = Page::all();
      return response()->json([
        'pages' => $pages,
      ]);
  }
  public function store(Request $request)
  {
      $input = $request->all();
      Page::create($input);
  }
  public function show($id)
  {
      return Page::findOrFail($id);
  }
  public function update(Request $request, $id)
  {
      $input = $request->all();
      Page::findOrFail($id)->update($input);
      // return Response::json($request->all()); //response()->json()
  }
  public function destroy($id)
  {
      return Page::destroy($id);
  }
}
