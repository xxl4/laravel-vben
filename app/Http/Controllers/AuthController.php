<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lauthz\Facades\Enforcer;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->fails(400, $validator->errors());
        }
        $credentials = request(['username', 'password']);
        if (!$token = auth('admin')->setTTL(9999999999)->attempt($credentials)) {
            return $this->fails(401, 'Username or password is wrong!');
        }
        $user = auth('admin')->user();
        $roles = Enforcer::getRolesForUser($user->id);
        $array = [];
        foreach($roles as $role) {
            $array += [[
                'name' => $role,
                'value' => $role,
            ]];
        }
        $user->token = $token;
        $user->role = $array;
        return $this->success(200, 'success', $user);
    }

    public function adminRefresh()
    {
        return $this->success(200, 'success', auth('admin')->refresh());
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->fails(401, $validator->errors());
        }
        $credentials = request(['username', 'password']);
        if (!$token = auth('user')->attempt($credentials)) {
            return $this->fails(400, 'Username or password is wrong');
        }
        return $this->success(200, 'success', $token);
    }

    public function register(Request $request)
    {
        # code...
    }
}
