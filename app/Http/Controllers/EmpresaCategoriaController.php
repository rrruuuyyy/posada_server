<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Categoria;
use App\Subcategoria;

class EmpresaCategoriaController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $idEmpresa
     * @return \Illuminate\Http\Response
     */
    public function index($idEmpresa)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        $categorias = $empresa->categorias()->get();
        for ($i=0; $i < count($categorias); $i++) { 
            $sub = Categoria::find($categorias[$i]->id)->subcategorias()->get();
            $categorias[$i]->subcategorias = $sub;

        }
        return response()->json(['status'=>true,'data'=>$categorias],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idEmpresa)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        if ( !$request->input('nombre') )
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
        $nuevaCategoria = $empresa->categorias()->create($request->all());
        return response()->json(['status'=>true,'data'=>$nuevaCategoria],200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa, $idCategoria)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        if ( !$request->input('nombre') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
        $categoria = $empresa->categorias()->find($idCategoria);
        if (!$categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una categoria con ese código asociado a la empresa.'])],404);
        }
        /// Primero comprobaremos si estamos recibiendo todos los campos.
		if ( !$request->input('nombre') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de actualizacion.'])],422);
        }
        $nombre=$request->input('nombre');
        $categoria->nombre = $nombre;
        $categoria->save();
        return response()->json(['status'=>true,'data'=>$categoria], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idEmpresa,$idCategoria)
    {
        $empresa = Empresa::find($idEmpresa);
        if (!$empresa)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un empresa con ese código.'])],404);
        }
        $categoria = Categoria::find($idCategoria);
        if (!$categoria)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una categoria con ese código asociado a ese categoria.'])],404);
        }
        $categoria->delete();
        return response()->json(['status'=>true,'message'=>'Se ha eliminado la categoria correctamente.'],200);
    }
}
