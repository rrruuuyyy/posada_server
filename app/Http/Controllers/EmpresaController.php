<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Categoria;
use App\Subcategoria;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa=Empresa::find($id);
		// Si no existe ese fabricante devolvemos un error.
		if (!$empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        $categorias = $empresa->categorias()->get();
        $empresa->categorias = $categorias;
        $ingresos = '';
        $mes = date('m');
        $year = date('Y');
        for ($i=0; $i < count($empresa->categorias) ; $i++) { 
            $sub = Categoria::find($empresa->categorias[$i]->id)->subcategorias()->get();
            for ($j=0; $j < count($sub) ; $j++) { 
                $ingresos = Subcategoria::find($sub[$j]->id)->ingresos()
                    ->whereMonth('created_at','=',$mes)
                    ->whereYear('created_at', '=', $year)
                    ->get();
                $egresos = Subcategoria::find($sub[$j]->id)->egresos()->get();
                $sub[$j]->ingresos = $ingresos;
                $sub[$j]->egresos = $egresos;
            }
            $empresa->categorias[$i]->subcategorias = $sub;
        }
		return response()->json(['status'=>'ok','data'=>$empresa],200);
    }
}
