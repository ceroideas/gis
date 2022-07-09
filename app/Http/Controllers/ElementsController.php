<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ElementsController extends Controller
{
    //
    public function test()
    {
        return DB::table('elementos_fibra')->get();
    }

    public function loginAdmin(){
        return redirect('/admin/home');
    }

    public function home(){
        $el = DB::table('elementos_fibra')->where('longitud' , '!=' , '')->where('id_red' , 5)->get();
        return view('admin.home' , compact('el'));
    }
}
