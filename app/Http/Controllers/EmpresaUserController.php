<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class EmpresaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idUsuario)
    {
        $usuario=User::find($idUsuario);
		if (! $usuario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usario con ese código.'])],404);
        }
		return response()->json(['status'=>true,'data'=>$usuario->empresas()->get()],200)->header('Content-Type', 'application/json');
		//return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$idUsuario)
    {
        /// Primero comprobaremos si estamos recibiendo todos los campos.
		if ( !$request->input('rfc') || !$request->input('nombre') || !$request->input('cp') || !$request->input('direccion') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
        $usuario= User::find($idUsuario);
        if (!$usuario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }
        $nuevaEmpresa = '';
        try {
            //code...
            $nuevaEmpresa = $usuario->empresas()->create($request->all());
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'data'=>$th->getMessage()],200);
        }
        return response()->json(['status'=>true,'data'=>$nuevaEmpresa],200);
        // $response = Response::make(json_encode(['data'=>$nuevaEmpresa]), 201)->header('Location', 'http://www.dominio.local/empresas/'.$nuevaEmpresa->rfc)->header('Content-Type', 'application/json');
		// return $response;
	    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request,$idUsuario,$idEmpresa)
    {
        // Comprobamos si el fabricante que nos están pasando existe o no.
        // $usuario = User::find($iduser);
        try {
            $usuario = User::find($idUsuario);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>false,'data'=>$th->getMessage()],200);
        }
		// Si no existe ese fabricante devolvemos un error.
		if (!$usuario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }		
        $empresa="";
		// El fabricante existe entonces buscamos el avion que queremos editar asociado a ese fabricante.
        try {
            $empresa = $usuario->empresas()->find($idEmpresa);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>false,'data'=>$th->getMessage()],200);
        }
		// Si no existe ese avión devolvemos un error.
		if (!$empresa)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código asociado a ese fabricante.'])],404);
        }
        /// Primero comprobaremos si estamos recibiendo todos los campos.
		if ( !$request->input('rfc') || !$request->input('nombre') || !$request->input('cp') || !$request->input('direccion') )
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }      
        $nombre=$request->input('nombre');
        $rfc=$request->input('rfc');
        $direccion=$request->input('direccion');
        $cp=$request->input('cp');
        $empresa->nombre = $nombre;
		$empresa->rfc = $rfc;
		$empresa->direccion = $direccion;
		$empresa->cp = $cp;
        $empresa->save();
        return response()->json(['status'=>true,'data'=>$empresa], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idUsuario,$idEmpresa)
    {
        $usuario = User::find($idUsuario);
        if (!$usuario)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un usuario con ese código.'])],404);
        }
        $empresa = $usuario->empresas()->find($idEmpresa);
        if (!$empresa)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una empresa con ese código asociado a ese usuario.'])],404);
        }
        $empresa->delete();
        return response()->json(['status'=>true,'mensaje'=>'Se ha eliminado la empresa correctamente.'],200);
    }
}
