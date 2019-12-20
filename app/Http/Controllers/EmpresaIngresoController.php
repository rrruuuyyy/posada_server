<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingreso;
use App\Empresa;
use App\Subcategoria;

class EmpresaIngresoController extends Controller
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
        $ingreso = new Ingreso($request->all());
        $ingreso->empresa()->associate($empresa);
        $ingreso->subcategoria()->associate($subcategoria);
        $ingreso->save();
        return response()->json(['status'=>true,'mensaje'=>'Ingreso creado','data'=>$ingreso],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idEmpresa,$idSubcategoria,$idIngreso)
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
        $ingreso = $subcategoria->ingresos()->find($idIngreso);
        if (!$ingreso)
		{
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un ingreso con ese código asociado a la empresa.'])],404);
        }
        if ( !$request->input('nombre') || !$request->input('cantidad') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de actualizacion.'])],422);
        }
        $ingreso->nombre = $request->input('nombre');
        $ingreso->cantidad = $request->input('cantidad');
        $ingreso->save();
        return response()->json(['status'=>true,'mensaje'=>'Ingreso actualizado','data'=>$ingreso], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idEmpresa,$idSubcategoria,$idIngreso)
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
        $ingreso = $subcategoria->ingresos()->find($idIngreso);
        if (!$ingreso)
		{
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un ingreso con ese código asociado a la empresa.'])],404);
        }
        $ingreso->delete();
        return response()->json(['status'=>true,'mensaje'=>'Se ha eliminado el ingreso correctamente.'],200);
    }
}
