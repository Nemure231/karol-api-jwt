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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'telepon' => 'required|numeric',
            'alamat' => 'required',
            'gambar' => 'required',
            'role_id' => 'required'
        ],[

            'name.required' => 'Harus diisi!',
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


        $model = new User;
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->password = Hash::make($request->input('password'));
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->gambar = $request->input('gambar');
        $model->role_id = $request->input('role_id');
        $model->status = $request->input('status');
        $model->save();
        //melakukan kondisi jika user berhasil terdaftar
        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => ''
            ], 201);
        }
    
    }

    public function ubahKaryawan(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'telepon' => 'required|numeric',
            'alamat' => 'required',
            'gambar' => 'required',
            'role_id' => 'required'
        ],[

            'name.required' => 'Harus diisi!',
            'email.required' => 'Harus diisi',
            'email.email' => 'Harus berformat email',
            'email.unique' => 'Email itu sudah ada',
            'telepon.required' => 'Harus diisi',
            'telepon.required' => 'Harus angka!',
            'alamat.required' => 'Harus diisi!',
            'gambar.required' => 'Harus diisi!',
            'role_id.required' => 'Harus dipilih!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan gagal diubah!',
                'data' => [
                    'name' => $validator->errors()->first('name'),
                    'email' => $validator->errors()->first('email'),
                    'telepon' => $validator->errors()->first('telepon'),
                    'alamat' => $validator->errors()->first('alamat'),
                    'gambar' => $validator->errors()->first('gambar'),
                    'role_id' => $validator->errors()->first('role_id')
                ]
            ], 422);
        }        

        //mengambil inputan untuk dimasukkan ke database

        $model = User::find($id);
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->gambar = $request->input('gambar');
        $model->role_id = $request->input('role_id');
        $model->status = $request->input('status');
        $model->save();
        
        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil diubah!',
                'data' => ''
            ], 201);
        }

        if(!$model){
            return response()->json([
                'success' => true,
                'message' => 'Karyawan gagal diubah!',
                'data' => ''
            ], 400);
        }
    
    }

    public function hapusKaryawan($id){

        $model = User::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Karyawan gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

}