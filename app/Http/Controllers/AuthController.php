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
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }        

        //mengambil inputan untuk dimasukkan ke database
        $register = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'telepon' => 0,
            'alamat' => '',
            'gambar' => 'default.png',
            'role_id' => 1,
            'status' => 1
        ]);
        //melakukan kondisi jika user berhasil terdaftar
        if($register){
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => ''
            ], 201);
        }

        if(!$register){
            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagai!',
                'data' => '',
            ], 400);
        }
    
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ],[

            'email.required' => 'Email harus diisi!',
            'email.email' => 'Harus berformat email!',
            'password.required' => 'Password harus diisi!',
            'password.string' => 'Harus berformat string!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(
                ['data' => 
                    ['error' => 'Unauthorized']
                ], 401);
        }

        return $this->respondWithToken($token);
    }


    public function me()
    {
        // response()->json(auth()->user());
        $id = auth()->user()->id;
        $data =  User::select('id', 'name', 'telepon', 'email', 'gambar', 'alamat', 'nama_role')
        ->join('role', 'users.role_id', '=', 'role.id_role')
        ->where('id', $id)
        ->first();

        $result = data_fill($data, 'url_gambar', asset('gambar/public').'/'.$data['gambar']);

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'User barhasil ditemukan!',
                    'data' => $result
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'User gagal ditemukan!',
                    'data' => ''
            ], 404);
        }


    }

    public function ambil_token(){

        $id_user = auth()->user()->id;

        return response()->json(auth()->tokenById($id_user));
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
