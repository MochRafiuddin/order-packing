<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use DataTables;

class CUser extends Controller
{
    public function index()
    {
         return view('user.index')->with('title','User');
    }
    public function create()
    {                   
        $url = url('user/create-save');
        return view('user.form')
            ->with('data',null)            
            ->with('title','User')
            ->with('titlePage','Tambah')
            ->with('url',$url);
    }
    public function show($id)
    {        
        $data = User::find($id);        
        $url = url('user/show-save/'.$id);
        return view('user.form')
            ->with('data',$data)
            ->with('title','User')
            ->with('titlePage','Edit')
            ->with('url',$url);
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }                
        
        $tipe = new User();
        $tipe->username = $request->username;
        $tipe->password = Hash::make($request->password);        
        $tipe->save();        

        return redirect()->route('user-index')->with('msg','Sukses Menambahkan Data');
    }
    public function show_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required',            
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }                
        
        $tipe = User::find($request->id);
        $tipe->username = $request->username;                
        if ($request->password != null) {
            $tipe->password = Hash::make($request->password);
        }
        $tipe->update();        

        return redirect()->route('user-index')->with('msg','Sukses Mengubah Data');
    }
    public function data()
    {
        $model = User::withDeleted();
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';       
                $btn .= '<a href="javascript:void(0)" data-toggle="modal"  data-id="'.$row->id_user.'" data-original-title="Password" class="text-success editPass mr-2"><span class="mdi mdi-lock-reset" data-toggle="tooltip" data-placement="Top" title="Reset Password"></span></a>';                   
                $btn .= '<a href="'.url('user/show/'.$row->id_user).'" class="text-danger mr-2"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit Data"></span></a>';                
                $btn .= '<a href="'.url('user/delete/'.$row->id_user).'" class="text-primary delete"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Hapus Data"></span></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function delete($id)
    {
        $m = User::find($id);
        $m->deleted = 0;
        $m->save();
        return redirect()->route('user-index')->with('msg','Sukses Menambahkan Data');
    }
    public function reset_password(Request $request)
    {   
        // echo $id;
        $user = User::find($request->id_user);
        $user->password = Hash::make($request->password);
        $user->update();
        return response()->json(['success'=>'Sukses Update Data']);
    }
    public function ubah_password(Request $request)
    {           
        $password_lama = $request->password_lama;
        $password_baru = $request->password_baru;

        $data = User::where('id_user',Auth::user()->id_user)->first();
        $cek = Hash::check($password_lama, $data->password);

        if ($cek == false) {
            return response()->json(['status'=>0, 'msg'=>'Password Lama Salah !']);
        }

        $user = User::find(Auth::user()->id_user);
        $user->password = Hash::make($password_baru);
        $user->update();

        return response()->json(['status'=>1, 'msg'=>'Sukses Ubah Password']);
    }
}
