<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategoria;
use App\Categoria;

class CategoriaSubcategoriaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idCategoria)
    {
        $categoria = Categoria::find($idCategoria);
        if (! $categoria)
		{
			return response()->json(['status'=>false,'mensaje'=>'No hay una categoria con ese codigo','error'=>'Categoria no encontrada'],200);
        }
        if ( !$request->input('nombre') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
        $subcategoria = $categoria->subcategorias()->create($request->all());
        return response()->json(['status'=>true,'mensaje'=>'Categoria creada','data'=>$subcategoria],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idCategoria,$idSubcategoria)
    {
        $categoria = Categoria::find($idCategoria);
        if (! $categoria)
		{
			return response()->json(['status'=>false,'mensaje'=>'No hay una categoria con ese codigo','error'=>'Categoria no encontrada'],200);
        }
        $subcategoria = $categoria->subcategorias()->find($idSubcategoria);
        if (!$subcategoria)
		{
            return response()->json(['status'=>false,'mensaje'=>'No hay una subcategoria con ese codigo','error'=>'Subcategoria no encontrada'],200);
        }
		if ( !$request->input('nombre') )
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de actualizacion.'])],422);
        }
        $nombre=$request->input('nombre');
        $subcategoria->nombre = $nombre;
        $subcategoria->save();
        return response()->json(['status'=>true,'data'=>$subcategoria], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCategoria, $idSubcategoria)
    {
        $categoria = Categoria::find($idCategoria);
        if(!$categoria)
        {
			return response()->json(['status'=>false,'mensaje'=>'No hay una categoria con ese codigo','error'=>'Categoria no encontrada'],200);
        }
        $subcategoria = $categoria->subcategorias()->find($idSubcategoria);
        if (!$subcategoria)
		{
            return response()->json(['status'=>false,'mensaje'=>'No hay una subcategoria con ese codigo','error'=>'Subcategoria no encontrada'],200);
        }
        $subcategoria->delete();
        return response()->json(['status'=>true,'mensaje'=>'Se ha eliminado la subcategoria correctamente.'],200);
    }
}
