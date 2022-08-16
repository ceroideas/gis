<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class ElementsController extends Controller
{
    //
    public function test()
    {
        // $capas = DB::table('elementos_fibra')->where('tipo' , 0)->take(20)->get();
        // dd($capas);
        // $tables = [Schema::getColumnListing('redes'),
        // Schema::getColumnListing('articulos_fabricante'),
        // Schema::getColumnListing('carta_fusiones'),
        // Schema::getColumnListing('grafica_fusiones'),
        // Schema::getColumnListing('nodos'),
        // Schema::getColumnListing('redes_geojson'),
        // Schema::getColumnListing('elementos_fibra'),
        // Schema::getColumnListing('capas'),
        $pl = Schema::getColumnListing('plantillas_cable');
        dd($pl);
        // return $tables;

        // $data = DB::table('plantillas_cable')->get();
        // $export = new DataExport($data);
        // return Excel::download($export, 'plantillas_cable.xlsx');
        // dd($data);

        // $array = Excel::toArray([], 'articulos_fabricante.xlsx');
        // foreach ($array as $key => $value) {
        // 	foreach ($value as $key2 => $value2) {
        // 		echo $value2[0];
        // 		DB::table('redes_geojson')->insert([
        // 			'id'         => $value2[0],
        // 			'id_red'     => $value2[1],
        // 			'nombre'     => $value2[2],
        // 			'geojson'    => $value2[3],
        // 			'tipo'       => $value2[4],
        // 			'created_at' => date('Y-m-d h:i:s'),
        // 			'updated_at' => date('Y-m-d h:i:s')
        // 		]);
        // 	}
        // }
        // foreach ($array as $key => $value) {
        // 	foreach ($value as $key2 => $value2) {
        // 		DB::table('articulos_fabricante')->insert([
        // 			'id'         => $value2[0],
        // 			'nombre'     => $value2[1],
        // 			'autor'      => $value2[2],
        // 			'empresaid'  => $value2[3],
        // 			'codigo'     => $value2[4],
        // 			'sistema'    => $value2[5],
        // 			'logotipo'   => $value2[6],
        // 			'created_at' => date('Y-m-d h:i:s'),
        // 			'updated_at' => date('Y-m-d h:i:s')
        // 		]);
        // 	}
        // }
        // dd($array);

        // $ef = DB::table('elementos_fibra')->where('tipo' , null)->get();
        // foreach ($ef as $key => $value) {
        // 	DB::table('elementos_fibra')->where('id' , $value->id)->update([
        // 		'tipo' => 0
        // 	]);
        // }
        // dd($ef);

  //       Schema::create("redes", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->string("proxy")->nullable();
		// 	$table->integer("id_cliente")->nullable();
		// 	$table->integer("id_agente")->nullable();
		// 	$table->timestamps();
		// });

		// Schema::create("articulos_fabricante", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->string("autor")->nullable();
		// 	$table->string("empresaid")->nullable();
		// 	$table->string("codigo")->nullable();
		// 	$table->string("sistema")->nullable();
		// 	$table->string("logotipo")->nullable();
		// 	$table->string("subir_ps")->nullable();
		// 	$table->integer("id_ps")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("carta_fusiones", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->integer("id_caja")->nullable();
		// 	$table->integer("id_origen")->nullable();
		// 	$table->string("fibra_origen")->nullable();
		// 	$table->integer("id_destino")->nullable();
		// 	$table->string("fibra_destino")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("grafica_fusiones", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	$table->integer("id_caja")->nullable();
		// 	$table->integer("id_elemento")->nullable();
		// 	$table->string("coordenadas")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("nodos", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->integer("id_red")->nullable();
		// 	$table->string("longitud_google")->nullable();
		// 	$table->string("latitud_google")->nullable();
		// 	$table->string("altura")->nullable();
		// 	$table->string("codigo_postal")->nullable();
		// 	$table->string("mapa")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("redes_geojson", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->integer("id_red")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->string("geojson")->nullable();
		// 	$table->string("tipo")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("elementos_fibra", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->integer("id_red")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->string("arqueta")->nullable();
		// 	$table->string("tipo")->nullable();
		// 	$table->string("salidas")->nullable();
		// 	$table->string("longitud")->nullable();
		// 	$table->string("latitud")->nullable();
		// 	$table->integer("id_cto")->nullable();
		// 	$table->string("tipo_cto")->nullable();
		// 	$table->integer("id_elemento_origen")->nullable();
		// 	$table->integer("id_elemento_destino")->nullable();
		// 	$table->text("path")->nullable();
		// 	$table->string("tipo_cable")->nullable();
		// 	$table->string("observaciones")->nullable();
		// 	$table->string("revisado")->nullable();
		// 	$table->integer("id_fichero")->nullable();
		// 	$table->integer("id_cable")->nullable();
		// 	$table->integer("id_capa")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("capas", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->string("nombre")->nullable();
		// 	$table->timestamps();
		// });
		// Schema::create("plantillas_cable", function (Blueprint $table) {
		// 	$table->increments('id');
		// 	// $table->integer("id")->nullable();
		// 	$table->integer("id_fabricante")->nullable();
		// 	$table->string("codigo")->nullable();
		// 	$table->string("descripcion")->nullable();
		// 	$table->string("numero_fibras")->nullable();
		// 	$table->string("color_fibras")->nullable();
		// 	$table->timestamps();
		// });


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
            'nombre'   => $r->description,
            'id_red'   => $r->active_red,
            'path'     => $r->paths,
            'tipo'     => $r->type_element,
            'latitud'  => $r->lt_element,
            'longitud' => $r->ln_element,
        ];
        $ins = DB::table('elementos_fibra')->insert($data);
        return $ins;
    }

    public function cablesTemplate(){
    	$tc = DB::table('plantillas_cable')->get();
    	return view('admin.cable_template' , compact('tc'));
    }


    public function saveCableTemplate(Request $r){
    	$tc = DB::table('plantillas_cable')->insert([
    		'codigo'        => $r->codigo,
    		'descripcion'   => $r->descripcion,
    		'numero_fibras' => $r->numero_fibras,
    		'color_fibras'  => $r->color_fibras,
    	]);

    	return response()->json([
    		'success' => true
    	]);
    }

    public function editCablesTemplate(Request $r , $id){
    	$tc = DB::table('plantillas_cable')->where('id' , $id)->update([
    		'codigo'        => $r->codigo,
    		'descripcion'   => $r->descripcion,
    		'numero_fibras' => $r->numero_fibras,
    		'color_fibras'  => $r->color_fibras,
    	]);

    	return response()->json([
    		'success' => true
    	]);
    }

    public function deleteCablesTemplate($id){
    	DB::table('plantillas_cable')->where('id' , $id)->delete();

    	return back()->with('msj' , 'Plantilla de cable eliminada exitosamente');
    }
}
