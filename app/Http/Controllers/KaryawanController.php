<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\File;
// use League\Flysystem\Filesystem;
// use League\Flysystem\Adapter\Local;
// use League\Flysystem\FilesystemInterface;
use Illuminate\Support\Facades\Storage;



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

            $index = 0;
            foreach ($data as $d):
                $result =data_fill($data, $index.'.url_gambar', asset('gambar/public').'/'.$d['gambar']);
                $index++;
            endforeach;

            return response()->json([
                    'success' => true,
                    'message' => 'Karyawan barhasil ditemukan!',
                    'data' => $result,
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
            'gambar' => 'image|max:1024|mimes:jpg,jepg,png|mimetypes:image/jpg,image/jpeg,image/png',
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
            // 'gambar.required' => 'Harus dipilih!',
            'gambar.image' => 'Harus gambar!',
            'gambar.max' => 'Minimal upload 1MB!',
            'gambar.mimes' => 'Tipe file tersebut bukan gambar!',
            'gambar.mimetype' => 'Tipe file tersebut bukan gambar!',
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

        $gambar = $request->file('gambar');
        $nama_file = $gambar->getClientOriginalName();

        if ($request->hasFile('gambar')) {
        
            if ($gambar->isValid()) {
                if ($nama_file != 'default.png'){

                    $nama_gambar = time().'_'.Str::slug($nama_file, '_');
                    $gambar->storeAs('public', $nama_gambar);    
                }else{
                    $nama_gambar = 'default.png';
                }
            }
        }

        if (!$request->hasFile('gambar')) {
            $nama_gambar = 'default.png';
        }

        $model = new User;
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->password = Hash::make($request->input('password'));
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->gambar = $nama_gambar;
        $model->role_id = $request->input('role_id');
        $model->status = $request->input('status');
        $model->save();
        
        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'data' => ''
            ], 201);
        }
    }

    public function ambilGambar($id){
    
        $data = User::select('gambar')->where('id', $id)->first();
        $path = '/app/gambar/karyawan';
        $avatar_path = storage_path($path).'/'.$data['gambar'];
        if (file_exists($avatar_path)) {
            
            $type = pathinfo($avatar_path, PATHINFO_EXTENSION);
            $dat = file_get_contents($avatar_path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($dat);

            return response()->json([
                'success' => true,
                'message' => 'Gambar barhasil ditemukan!',
                'data' => $base64
            ], 200);
        }

        if (!file_exists($avatar_path)) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan!',
                'data' => ''
            ], 200);
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