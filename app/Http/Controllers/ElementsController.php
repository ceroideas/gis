<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ElementsController extends Controller
{
    //
    public function test()
    {
        return DB::select("SELECT * FROM INFORMATION_SCHEMA.tables where table_schema = 'public'");
        return DB::table('elementos_fibra')->get();
    }

    public function loginAdmin(){
        return redirect('/admin/home');
    }

    public function home(){
        $el = DB::table('elementos_fibra')->where('longitud' , '!=' , '')->where('id_red' , 5)->get();
        return view('admin.home' , compact('el'));
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
}
