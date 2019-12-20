<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingresos';
    protected $primaryKey = 'id';
    // Atributos que se pueden asignar de manera masiva.
    protected $fillable = array('nombre','cantidad','empresa_id','subcategoria_id');
    // Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
    protected $hidden = ['created_at','updated_at'];
    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
    public function subcategoria(){
        return $this->belongsTo('App\Subcategoria');
    }
}
