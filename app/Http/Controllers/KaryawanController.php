<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function ambilKaryawan(){

        $data =  User::select('name', 'telepon', 'email', 'gambar', 'alamat', 'nama_role', 'id', 'status', 'role_id')
            ->join('role', 'users.role_id', '=', 'role.id_role')
            ->get();
        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Karyawan barhasil ditemukan!',
                    'data' => $data
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

    public function tambahKaryawan(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'telepon' => 'required|numeric',
            'alamat' => 'required',
            'gambar' => 'required',
            'role_id' => 'required'
        ],[

            'name.required' => 'Harus diisi!',
            'name.string' => 'Nama itu sudah ada!',
            'email.required' => 'Harus diisi',
            'email.email' => 'Harus berformat email',
            'email.unique' => 'Email itu sudah ada',
            'password.required' => 'Harus diisi',
            'password.confirmed' => 'Konfirmasi password harus sama!',
            'telepon.required' => 'Harus diisi',
            'telepon.required' => 'Harus angka!',
            'alamat.required' => 'Harus diisi!',
            'gambar.required' => 'Harus diisi!',
            'role_id.required' => 'Harus dipilih!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan gagal ditambahkan!',
                'data' => [
                    'name' => $validator->errors()->first('name'),
                    'email' => $validator->errors()->first('email'),
                    'password' => $validator->errors()->first('password'),
                    'telepon' => $validator->errors()->first('telepon'),
                    'alamat' => $validator->errors()->first('alamat'),
                    'gambar' => $validator->errors()->first('gambar'),
                    'role_id' => $validator->errors()->first('role_id')
                ]
            ], 422);
        }        

        //mengambil inputan untuk dimasukkan ke database
        $register = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'telepon' => $request->input('telepon'),
            'alamat' => $request->input('alamat'),
            'gambar' => $request->input('gambar'),
            'role_id' => $request->input('role_id'),
            'status' => $request->input('status')
        ]);
        //melakukan kondisi jika user berhasil terdaftar
        if($register){

            // $gambar->move('storage/app/karyawan', $request->input('gambar'));

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => ''
            ], 201);
        }
    
    }

}