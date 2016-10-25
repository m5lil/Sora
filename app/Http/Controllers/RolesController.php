<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Http\Requests;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $role = new Role();
        // print_r($request->selected_pers);
        // dd($request->selected_pers);
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();
        foreach ($request->input('selected_pers') as $key => $value) {
          $role->attachPermission($value);
        }
        //
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $perms = $role->perms()->pluck('id');
        // dd($perms);
        return response()->json([
            'role' => $role,
            'selected_pers' => $perms
        ]);
    }

    public function update(Request $request, $id)
    {
      $input = $request->all();
      $role = Role::findOrFail($id);
      // dd($request->selected_pers);
      $role->name = $request->input('name');
      $role->display_name = $request->input('display_name');
      $role->description = $request->input('description');
      $role->save();
      $role->perms()->sync($request->input('selected_pers'));
      // foreach ($request->input('selected_pers') as $key => $value) {
      //     $role->attachPermission($value);
      // }
        // return Response::json($request->all()); //response()->json()
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->users()->sync([]); // Delete relationship data
        $role->perms()->sync([]); // Delete relationship data

        $role->forceDelete(); // Now force delete will work regardless of whether the pivot table has cascading delete

    }

}
