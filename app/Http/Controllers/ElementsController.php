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
}
