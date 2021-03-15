<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return response()->json(['data' =>  $data], 200);
    }

    public function ambilSatuUser($id){

        $data =  User::select('name', 'telepon', 'email', 'gambar', 'alamat')
            ->where('id', $id)
            ->first();

        return response()->json(['data' =>  $data], 200);
    }

    public function ambilSatuUserUntukProfil($id){

        $data =  User::select('name', 'gambar')
            ->where('id', $id)
            ->first();

        return response()->json(['data' =>  $data], 200);
    }

    public function ubahUser(Request $request, $id){

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
        }else{
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
        return response()->json(['data' =>  $data], 200);
    }

    public function ubahSandi(Request $request, $id){
      
		$sandi = User::find($id);
		$sandi_lama = $request->input('sandi_lama');
		$sandi_baru = $request->input('sandi_baru');

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