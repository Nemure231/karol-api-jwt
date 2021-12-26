<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

    public function ambilSatuUserJoinRole($id){

        $data =  User::select('name', 'telepon', 'email', 'gambar', 'alamat', 'nama_role')
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

    public function ambilSatuUser($id){
        
        $data =  User::select('name', 'telepon', 'email', 'gambar', 'alamat')
            ->where('id', $id)
            ->first();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'User barhasil ditemukan!',
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

    public function ambilSatuUserUntukProfil($id){
        $data =  User::select('name', 'gambar')
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

    public function ubahUser(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' =>  'required|unique:users,name,'.$id,
            'telepon' => 'required|numeric',
            'alamat' => 'required',
        ],[
            'name.required' => 'Harus diisi!',
            'name.unique' => 'Nama itu sudah ada!',
            'telepon.required' => 'Harus diisi!',
            'telepon.numeric' => 'Harus angka!',
            'alamat.required' => 'Harus diisi!',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubah!',
                'data' => [
                    'name' => $validator->errors()->first('name'),
                    'telepon' => $validator->errors()->first('telepon'),
                    'alamat' => $validator->errors()->first('alamat'),
                ]
                
            ], 422);
        }

       

        $model = User::find($id);
        $model->name = $request->input('name');
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubahh!',
                'data' => '',
            ], 400);
        }

    }

    public function ambilSatuSandi($id){
        $data =  User::select('password')
            ->where('id', $id)
            ->first();
        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Sandi barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Sandi gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }

    public function ubahSandi(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'password_lama' =>  'required',
            'password' => 'required|min:8|confirmed',
        ],[
            'password_lama.required' => 'Harus diisi!',
            'password.required' => 'Harus diisi',
            'password.min' => 'Terlalu pendek!',
            'password.confirmed' => 'Konfirmasi sandi harus sama dengan sandi baru!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah!',
                'data' => [
                    'password_lama' => $validator->errors()->first('password_lama'),
                    'password' => $validator->errors()->first('password'),
                ]
                
            ], 422);
        }
      
		$sandi = User::find($id);
		$sandi_lama = $request->input('password_lama');
		$sandi_baru = $request->input('password');

		if (!password_verify($sandi_lama, $sandi['password'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sandi lama salah!',
                    'data' => '',
                ], 400);
		}else{
			if ($sandi_lama == $sandi_baru) {
				return response()->json([
                    'success' => false,
                    'message' => 'Sandi baru tidak boleh sama dengan sandi lama!',
                    'data' => '',
                ], 400);

			}else{
                $sandi_hash = Hash::make($sandi_baru);
                $model = User::find($id);
                $model->password = $sandi_hash;
                $model->save();

				return response()->json([
                    'success' => true,
                    'message' => 'Sandi berhasil diubah!',
                    'data' => ''
                ], 201);
			}
		}
    }


}