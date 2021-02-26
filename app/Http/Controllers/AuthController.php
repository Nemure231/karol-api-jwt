<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
 
    public function register(Request $request){
        //melakukan validasi
        Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ],[

            'name.required' => 'Harus dipilih!',
            'name.string' => 'Nama itu sudah ada!',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus berformat email',
            'email.unique' => 'Email itu sudah ada',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password harus sama!'
        ])->validate();

        //mengambil inputan untuk dimasukkan ke database
        $register = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        //melakukan kondisi jika user berhasil terdaftar
        if($register){
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => $register
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal!',
                'data' => '',
            ], 400);
        }
    
    }

    public function login()
    {
        // Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|string',
        // ],[

        //     'email.required' => 'Email harus diisi!',
        //     'email.email' => 'Harus berformat email!',
        //     'password.required' => 'Password harus diisi!',
        //     'password.string' => 'Harus berformat string!'
        // ])->validate();

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Get some user from somewhere
        $user = User::first();

        // Get the token
        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
