<?php

namespace App\Http\Controllers;

use App\Models\MKurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CKurir extends Controller
{
    public function index()
    {
         return view('kurir/index')
         ->with('title','Kurir');
    }
    public function create()
    {                           
        $url = url('kurir/create-save');
        return view('kurir.form')
            ->with('data',null)            
            ->with('title','Kurir')
            ->with('titlePage','Tambah')
            ->with('url',$url);
    }    
    public function show($id)
    {           
        $data = MKurir::find($id);
        $url = url('kurir/show-save/'.$id);
        return view('kurir.form')
            ->with('data',$data)            
            ->with('title','Kurir')
            ->with('titlePage','Edit')
            ->with('url',$url);
    }
    public function detail($id)
    {        
        $data = MKurir::find($id);
        return view('kurir.detail')
            ->with('data',$data)
            ->with('title','Kurir')
            ->with('titlePage','Detail');
    }
    public function create_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        
        // $gambar = round(microtime(true) * 1000).'.'.$request->file('gambar')->extension();
        // $request->file('gambar')->move(public_path('upload/kota'), $gambar);           
        
            $tipe = new MKurir();
            $tipe->nama = $request->nama;
            $tipe->save();        

        return redirect()->route('kurir-index')->with('msg','Sukses Menambahkan Data');
    }
    public function show_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($validator->errors());
        }
        
        MKurir::where('id',$request->id)->update(['nama'=>$request->nama]);

        return redirect()->route('kurir-index')->with('msg','Sukses Menambahkan Data');
    }
    public function delete($id)
    {
        // MKurir::updateDeleted($id);
        MKurir::where('id',$request->id)->update(['deleted'=>0]);
        return redirect()->route('kurir-index')->with('msg','Sukses Menambahkan Data');

    }
    public function data()
    {
        $model = MKurir::where('m_kurir.deleted',1);
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                                
                $btn .= '<a href="'.url('kurir/detail/'.$row->id).'" class="text-warning mr-2"><span class="mdi mdi-information-outline" data-toggle="tooltip" data-placement="Top" title="Detail Data"></span></a>';                
                $btn .= '<a href="'.url('kurir/show/'.$row->id).'" class="text-danger mr-2"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit Data"></span></a>';                
                $btn .= '<a href="'.url('kurir/delete/'.$row->id).'" class="text-primary delete"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Hapus Data"></span></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
