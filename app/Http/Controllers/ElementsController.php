<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ElementsController extends Controller
{
    //
    public function test()
    {
        $capas = DB::table('elementos_fibra')->where('tipo' , 0)->take(20)->get();
        dd($capas);
        dd(DB::select("SELECT * FROM INFORMATION_SCHEMA.tables where table_schema = 'public'"));
    }

    public function loginAdmin(){
        return redirect('/admin/home');
    }

    public function home(){
        $red = DB::table('redes')->first();
        return view('admin.home' , compact('red'));
    }

    public function uploadOverlay(Request $r)
    {
        $name = 'file_'.uniqid().'.'.$r->image->getClientOriginalExtension();
        $r->image->move(public_path().'/uploads',$name);

        return [
            "url" => url('uploads',$name),
            "stLat" => $r->stLat,
            "stLon" => $r->stLon,
            "fnLat" => $r->fnLat,
            "fnLon" => $r->fnLon,
            "opacity" => $r->opacity,
        ];
    }

    public function loadRedData($id){
        $nod = DB::table('nodos')->where('id_red' , $id)->get();
        $coo = DB::table('nodos')->where('latitud_google' , '!=' , '')->where('id_red' , $id)->first();
        if(!$coo){
            $coo = DB::table('elementos_fibra')->where('latitud' , '!=' , '')->where('id_red' , $id)->first();
        }

        $box = DB::table('elementos_fibra')->where('tipo' , 0)->where('id_red' , $id)->get();
        $spi = DB::table('elementos_fibra')->where('tipo' , 2)->where('id_red' , $id)->get();
        $cab = DB::table('elementos_fibra')->where('tipo' , 3)->where('id_red' , $id)->get();
        $pos = DB::table('elementos_fibra')->where('tipo' , 4)->where('id_red' , $id)->get();
        $arq = DB::table('elementos_fibra')->where('tipo' , 5)->where('id_red' , $id)->get();
        $arm = DB::table('elementos_fibra')->where('tipo' , 6)->where('id_red' , $id)->get();
        return response()->json([
            'nod' => $nod,
            'box' => $box,
            'spi' => $spi,
            'coo' => $coo,
            'cab' => $cab,
            'pos' => $pos,
            'arq' => $arq,
            'arm' => $arm,
        ]);
    }

    public function saveNewElement(Request $r){
        $data = [
            'nombre' => $r->description,
            'id_red' => $r->active_red,
            'path'   => $r->paths,
            'tipo'   => $r->type_element
        ];
        $ins = DB::table('elementos_fibra')->insert($data);
        return $ins;
    }
}
