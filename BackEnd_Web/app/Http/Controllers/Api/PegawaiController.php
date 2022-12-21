<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;
use Illuminate\Support\Carbon;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais=Pegawai::all();

        if(count($pegawais)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$pegawais
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }


    public function store(Request $request)
    {
        $carbon=Carbon::now();
        $dateY=$carbon->format('y');
        $dateM=$carbon->format('m');
        $dateD=$carbon->format('d');

        $totalUser=sprintf('%03d',(Pegawai::all()->count())+1);
        $stringKode='PGW-'.$dateY.$dateM.$dateD.'-'.$totalUser;

        $storeData=$request->all();
        $validate=Validator::make($storeData,[
            'nama_pegawai'=>'required|max:60|unique:pegawais',
            'posisi'=>'required',
            'nomor_telepon'=>'required|numeric'
        ]);

        if($validate->fails())
        return response()->json($validate->errors(), 400);
        
            $pegawai=Pegawai::create($storeData+['kode'=>$stringKode]);
            return response([
                'message'=>'add pegawai success',
                'data'=>$pegawai
            ],200);
    }

    public function show($id)
    {
        $pegawai=Pegawai::find($id);

        if(!is_null($pegawai)){
            return response([
                'message'=>'retrieve pegawai success',
                'data'=>$pegawai
            ],200);
        }

        return response([
            'message'=>'Pegawai not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        if(is_null($pegawai)){
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_pegawai' => ['required', 'max:60', Rule::unique('pegawais')->ignore($pegawai)],
            'posisi' => 'required',
            'nomor_telepon' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai->nama_pegawai = $updateData['nama_pegawai'];
        $pegawai->posisi = $updateData['posisi'];
        $pegawai->nomor_telepon = $updateData['nomor_telepon'];

        if($pegawai->save()){
            return response([
                'message' => 'Update Pegawai Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Pegawai Failed',
            'data' => null
        ], 400);

    }

    
    public function destroy($id)
    {
        $pegawai=Pegawai::find($id);

        if(is_null($pegawai)){
            return response([
                'message'=>'Pegawai not found',
                'data'=>null
            ],404);
        }

        if($pegawai->delete()){
            return response([
                'message'=>'delete Pegawai success',
                'data'=>$pegawai
            ],200);
        }

        return response([
            'message'=>'delete Pegawai failed',
            'data'=>null
        ],400);
    }
}
