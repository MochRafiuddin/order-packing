<?php

namespace App\Http\Controllers;

use App\Models\MMarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CMarketplace extends Controller
{
    public function index()
    {
         return view('marketplace/index')
         ->with('title','Market Place');
    }
    public function create()
    {                           
        $url = url('marketplace/create-save');
        return view('marketplace.form')
            ->with('data',null)            
            ->with('title','Market Place')
            ->with('titlePage','Tambah')
            ->with('url',$url);
    }    
    public function show($id)
    {           
        $data = MMarketPlace::find($id);
        $url = url('marketplace/show-save/'.$id);
        return view('marketplace.form')
            ->with('data',$data)            
            ->with('title','Market Place')
            ->with('titlePage','Edit')
            ->with('url',$url);
    }
    public function detail($id)
    {        
        $data = MMarketPlace::find($id);
        return view('marketplace.detail')
            ->with('data',$data)
            ->with('title','Market Place')
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
        
            $tipe = new MMarketPlace();
            $tipe->nama = $request->nama;
            $tipe->save();        

        return redirect()->route('marketplace-index')->with('msg','Sukses Menambahkan Data');
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
        
        MMarketPlace::where('id',$request->id)->update(['nama'=>$request->nama]);

        return redirect()->route('marketplace-index')->with('msg','Sukses Menambahkan Data');
    }
    public function delete($id)
    {
        // MMarketPlace::updateDeleted($id);
        MMarketPlace::where('id',$request->id)->update(['deleted'=>0]);
        return redirect()->route('marketplace-index')->with('msg','Sukses Menambahkan Data');

    }
    public function data()
    {
        $model = MMarketPlace::where('m_marketplace.deleted',1);
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';                                
                $btn .= '<a href="'.url('marketplace/detail/'.$row->id).'" class="text-warning mr-2"><span class="mdi mdi-information-outline" data-toggle="tooltip" data-placement="Top" title="Detail Data"></span></a>';                
                $btn .= '<a href="'.url('marketplace/show/'.$row->id).'" class="text-danger mr-2"><span class="mdi mdi-pen" data-toggle="tooltip" data-placement="Top" title="Edit Data"></span></a>';                
                $btn .= '<a href="'.url('marketplace/delete/'.$row->id).'" class="text-primary delete"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Hapus Data"></span></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
