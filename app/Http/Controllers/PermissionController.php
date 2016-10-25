<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Http\Requests;

class PermissionController extends Controller
{
  public function index()
  {
      $permissions = Permission::all();
      return response()->json([
          'permissions' => $permissions,
      ]);
  }

  public function store(Request $request)
  {
      $input = $request->all();
      Permission::create($input);
  }

  public function show($id)
  {
      // return Permission::findOrFail($id);
      $permission = Permission::findOrFail($id);
      // dd($perms);
      return response()->json([
          'permission' => $permission,
      ]);

  }

  public function update(Request $request, $id)
  {
      $input = $request->all();
      $role = Permission::findOrFail($id);
      // dd($request->selected_pers);
      $role->name = $request->input('name');
      $role->display_name = $request->input('display_name');
      $role->description = $request->input('description');
      $role->save();
  }

  public function destroy($id)
  {
      Permission::destroy($id);
  }
}
