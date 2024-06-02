<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'full_name' => "required",
            'username' => "required",
            'password' => "required",
            'bio' => "required",
        ]);

        if ($validate->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "errors" => $validate->errors()
            ], 200);
        }

        $input = $request->all();
        $input["password"] = Hash::make($request->password);
        $user = User::create($input);
        return response()->json([
            "message" => "Register success",
            "token" => $user->createToken("token")->plainTextToken(),
            "user" => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'msg' => 'wrong field'
            ], 200);
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::where('username', $request->username);
        if (!$user || Hash::check($request->password, $user->password)) {
            return response()->json([
                'msg' => 'wrong username or password'
            ], 200);
        }
        return response()->json([
            "message" => "Login success",
            "token" => $user->createToken('token')->plainTextToken(),
            "user" => $user
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'msg' => 'berhasil logout'
        ], 200);
    }
}
