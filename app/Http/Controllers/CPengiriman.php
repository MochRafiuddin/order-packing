<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MPengiriman;
use App\Models\MMarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Smalot\PdfParser\Parser;

class CPengiriman extends Controller
{
    public function index()
    {
        $market = MMarketPlace::where('deleted',1)->get();
         return view('pengiriman/index')
         ->with('mulai',date('d-m-Y'))
         ->with('market',$market)
         ->with('title','Pengiriman');
    }
    public function create()
    {                           
        $url = url('pengiriman/create-save');
        return view('pengiriman.form')
            ->with('data',null)            
            ->with('title','Pengiriman')
            ->with('titlePage','Tambah')
            ->with('url',$url);
    }    
    public function show($id)
    {           
        $data = MPengiriman::find($id);
        $url = url('pengiriman/show-save/'.$id);
        return view('pengiriman.form')
            ->with('data',$data)            
            ->with('title','Pengiriman')
            ->with('titlePage','Edit')
            ->with('url',$url);
    }
    public function detail($id)
    {        
        $data = MPengiriman::find($id);
        return view('pengiriman.detail')
            ->with('data',$data)
            ->with('title','Pengiriman')
            ->with('titlePage','Detail');
    }
    public function create_save(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'file' => 'required',
        // ]);
        
        // if ($validator->fails()) {
        //     return redirect()->back()
        //                 ->withInput($request->all())
        //                 ->withErrors($validator->errors());
        // }

        $files = $request->file('file');

        // foreach ($files as $key) {
            $my_pdf_path_for_example = 'upload/'.date('Ymd');

            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($files->path());
            $content = $pdf->getText();

            // $content = '';

            if (str_contains($content, 'EZ')) { 
                $id_marketplace=3;
            }else{
                $id_marketplace=1;
            }

            if (!file_exists(public_path($my_pdf_path_for_example))) {
                mkdir(public_path($my_pdf_path_for_example), 0777, true);                

                $tipe = new MPengiriman();
                $tipe->kode = $files->getClientOriginalName();
                $tipe->tanggal = date('Y-m-d');
                $tipe->id_marketplace = $id_marketplace;
                $tipe->id_kurir = 1;
                $tipe->cetak = 0;
                $tipe->verifikasi = 0;
                $tipe->save();

                $files->move($my_pdf_path_for_example, $files->getClientOriginalName());
            }else{
                $tipe = new MPengiriman();
                $tipe->kode = $files->getClientOriginalName();
                $tipe->tanggal = date('Y-m-d');
                $tipe->id_marketplace = $id_marketplace;
                $tipe->id_kurir = 1;
                $tipe->cetak = 0;
                $tipe->verifikasi = 0;
                $tipe->save();

                $files->move($my_pdf_path_for_example, $files->getClientOriginalName());
            }
        // }            
        return response()->json(['status' => 'ok', 'path' => $my_pdf_path_for_example.'/'.$files->getClientOriginalName()]);
        // return redirect()->route('pengiriman-index')->with('msg','Sukses Menambahkan Data');
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
        
        MPengiriman::where('id',$request->id)->update(['nama'=>$request->nama]);

        return redirect()->route('pengiriman-index')->with('msg','Sukses Menambahkan Data');
    }
    public function delete($id)
    {
        // MPengiriman::updateDeleted($id);
        MPengiriman::where('id',$id)->update(['deleted'=>0]);
        return redirect()->route('pengiriman-index')->with('msg','Sukses Menambahkan Data');

    }
    public function print(Request $request)
    {        
        $log = MPengiriman::find($request->id);
        $log->cetak = 1;
        $log->update();
        // dd($dataExcel);
        return response()->json(['status'=>true]);

    }
    public function verifikasi(Request $request)
    {   
        $log = MPengiriman::find($request->id);

        if ($request->varifikasi == 0) {
            $my_pdf_path_for_example = 'upload/'.date('Ymd',strtotime($log->tanggal)).'/image/';            
            $img = $request->image;
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $file = $my_pdf_path_for_example . $fileName;

            // dd($files);
            if (!file_exists(public_path($my_pdf_path_for_example))) {
                mkdir(public_path($my_pdf_path_for_example), 0777, true);
                file_put_contents($file, $image_base64);
            }else{
                file_put_contents($file, $image_base64);
            }            
            $log1 = MPengiriman::find($request->id);
            $log1->file = $fileName;
            $log1->verifikasi = 1;            
            $log1->update();
        }else{
            // dd($request->varifikasi);            
            MPengiriman::where('id',$request->id)->update(['verifikasi' => $request->varifikasi, 'catatan_verif' => $request->catatan]);            
        }
                
        // dd($dataExcel);
        return response()->json(['status'=>true]);

    }
    public function data(Request $request)
    {
        $model = MPengiriman::join('m_marketplace','m_marketplace.id','m_pengiriman.id_marketplace')
            ->join('m_kurir','m_kurir.id','m_pengiriman.id_kurir')
            ->select('m_pengiriman.*', 'm_marketplace.nama as nama_marketplace', 'm_kurir.nama as nama_kurir')
            ->where('m_pengiriman.deleted',1)
            ->where('m_pengiriman.tanggal',date('Y-m-d',strtotime($request->tanggal)));
        if ($request->market) {
            $model = $model->where('id_marketplace',$request->market);
        }
        return DataTables::eloquent($model)
            ->addColumn('action', function ($row) {
                $btn = '';
                $pdf = asset('upload/'.date('Ymd',strtotime($row->tanggal)).'/'.$row->kode);
                if ($row->file != null) {                    
                    $gambar = asset('upload/'.date('Ymd',strtotime($row->tanggal)).'/image/'.$row->file);
                }else {
                    $gambar = '';
                }                
                
                $btn .= '<a href="javascript:void(0)" data-toggle="modal" data-id="'.$row->id.'" data-pdf="'.$pdf.'" data-original-title="Edit" class="mr-2 text-success editPost"><span class="mdi mdi-printer" data-toggle="tooltip" data-placement="Top" title="Print"></span></a>';
                $btn .= '<a href="javascript:void(0)" data-toggle="modal" data-id="'.$row->id.'" data-pdf="'.$pdf.'" data-verifikasi="'.$row->verifikasi.'" data-gambar="'.$gambar.'" data-catatan="'.$row->catatan_verif.'" data-original-title="Edit" class="mr-2 text-warning varifPost"><span class="mdi mdi-checkbox-marked-outline" data-toggle="tooltip" data-placement="Top" title="Verifikasi"></span></a>';
                $btn .= '<a href="'.url('pengiriman/delete/'.$row->id).'" class="text-primary delete"><span class="mdi mdi-delete" data-toggle="tooltip" data-placement="Top" title="Hapus Data"></span></a>';
                return $btn;
            })
            ->editColumn('cetak', function ($row) {
                if ($row->cetak == 0) {                    
                    $btn = 'Belum';
                }else {
                    $btn = 'Sudah';
                }
                
                return $btn;
            })
            ->editColumn('verifikasi', function ($row) {
                if ($row->verifikasi == 0) {                    
                    $btn = 'Belum';
                }elseif ($row->verifikasi == 1) {
                    $btn = 'Menunggu';
                }elseif ($row->verifikasi == 2) {
                    $btn = 'Approve';
                }else {
                    $btn = 'Tolak';
                }
                
                return $btn;
            })
            ->editColumn('tanggal', function ($row) {                
                $btn = date('d-m-Y',strtotime($row->tanggal));
                
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
