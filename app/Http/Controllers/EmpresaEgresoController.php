<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Egreso;
use App\Empresa;
use App\Subcategoria;

class EmpresaEgresoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idEmpresa,$idSubcategoria)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        $subcategoria = Subcategoria::find($idSubcategoria);
        if (! $subcategoria)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una subcategoria con ese código.'])],404);
        }
        if ( !$request->input('nombre') || !$request->input('cantidad') )
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
        $egreso = new Egreso($request->all());
        $egreso->empresa()->associate($empresa);
        $egreso->subcategoria()->associate($subcategoria);
        $egreso->save();
        return response()->json(['status'=>true,'mensaje'=>'Egreso creado','data'=>$egreso],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa,$idSubcategoria,$idEgreso)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        $subcategoria = Subcategoria::find($idSubcategoria);
        if (! $subcategoria)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una subcategoria con ese código.'])],404);
        }
        $egreso = $subcategoria->egresos()->find($idEgreso);
        if (!$egreso)
		{
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un egreso con ese código asociado a la empresa.'])],404);
        }
        if ( !$request->input('nombre') || !$request->input('cantidad') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de actualizacion.'])],422);
        }
        $egreso->nombre = $request->input('nombre');
        $egreso->cantidad = $request->input('cantidad');
        $egreso->save();
        return response()->json(['status'=>true,'mensaje'=>'Egreso actualizado','data'=>$egreso], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idEmpresa,$idSubcategoria,$idEgreso)
    {
        $empresa = Empresa::find($idEmpresa);
        if (! $empresa)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código.'])],404);
        }
        $subcategoria = Subcategoria::find($idSubcategoria);
        if (! $subcategoria)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una subcategoria con ese código.'])],404);
        }
        $egreso = $subcategoria->egresos()->find($idEgreso);
        if (!$egreso)
		{
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un egreso con ese código asociado a la empresa.'])],404);
        }
        $egreso->delete();
        return response()->json(['status'=>true,'mensaje'=>'Se ha eliminado el egreso correctamente.'],200);
    }
}
