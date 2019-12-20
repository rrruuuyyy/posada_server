<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $table='empresas';
    protected $primaryKey = 'id';
    // Atributos que se pueden asignar de manera masiva.
    protected $fillable = array('nombre','direccion','cp','rfc','usuario_id');
    // Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
    protected $hidden = ['created_at','updated_at'];
    
    public function usuario(){
        return $this->belongsTo('App\User');
    }
    public function categorias(){
        return $this->hasMany('App\Categoria','empresa_id');
    }
    public function ingresos(){
        return $this->hasMany('App\Ingreso','empresa_id');
    }
    public function egresos(){
        return $this->hasMany('App\Egreso','empresa_id');
    }
}
