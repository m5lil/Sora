<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
// use App\Page;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        foreach ($menus as $value) {
          if ($value->parent_id == 0) {
            $menu[] = $value;
            $menu_witout_parent[] = $value;
            if ( ! $value->children->isEmpty() ) {
              foreach ($value->children as $subMenuItem) {
                $menu[] = $subMenuItem;
              }
            }
          }
        }
        // echo "<pre>" . $menus . "</pre>" ;
        return response()->json([
          'menus' => $menu,
        ]);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        Menu::create($input);
    }
    public function show($id)
    {
        return Menu::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        Menu::findOrFail($id)->update($input);
        // return Response::json($request->all()); //response()->json()
    }
    public function destroy($id)
    {
        return Menu::destroy($id);
    }
}
