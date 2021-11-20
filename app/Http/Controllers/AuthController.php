<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # membuat method register
    function register(Request $request)
    {
        # membuat inputan yang akan dimasukkan ke dalam database
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        # menggunakan class user untuk membuat inputan
        User::create($input);

        $data = [
            'message' => 'User berhasil dibuat'
        ];

        #mengembalikan data json dan kode 200
        return response()->json($data, 200); 
    }

    # membuat method login 
    function login(Request $request)
    {
        # hanya email dan password yang akan dicocokan 
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        # menggunakan class user utuk mencocokkan email user
        $user = User::where('email', $input['email'])->first();

        # mengubah dari token menjadi password yang di input
        $LoginSuccessfuly = (
            Auth::attempt()
        );

        if ($LoginSuccessfuly) {
            
            # mengembalikan banyaknya login dan token 
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login successfuly',
                'token' => $token->plainTextToken
            ];
 
            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);
        }
        else {

            $data = [
                'message' => 'Username or Password is wrong'
            ];

            # mengembalikan peasan dan kode 401
            return response()->json($data, 401);
        }
    }
}
