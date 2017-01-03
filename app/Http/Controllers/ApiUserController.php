<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;
use App\Http\Requests;

class ApiUserController extends Controller
{
     public function index()
    {
        $roles = Role::select('id','name')->get();
        $data = User::paginate(20);
        return response()->json([
            'data' => $data,
            'roles' => $roles
        ]);
        // $items = User::latest()->paginate(20);
        // $response = [
        //     'pagination' => [
        //         'total' => $items->total(),
        //         'per_page' => $items->perPage(),
        //         'current_page' => $items->currentPage(),
        //         'last_page' => $items->lastPage(),
        //         'from' => $items->firstItem(),
        //         'to' => $items->lastItem()
        //     ],••••••••••••••••••••••
        //     'data' => $items
        // ];
        // return $response
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        User::create($input);
    }
    public function show($id)
    {
        $data = User::findOrFail($id);
        $avatar = 'http://www.gravatar.com/avatar/' . md5($data->email) . '?s=32';
        return response()->json([
            'data' => $data,
            'avatar' => $avatar
        ]);


    }
    public function update(Request $request, $id)
    {
      $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] =  bcrypt($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }
        User::findOrFail($id)->update($input);
        // return Response::json($request->all()); //response()->json()
    }
    public function destroy($id)
    {
        $ids = explode(",",$id);
        // dd($ids);
        return User::destroy($ids);
    }
}
