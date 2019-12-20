<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $table='subcategorias';
    protected $primaryKey = 'id';
    // Atributos que se pueden asignar de manera masiva.
    protected $fillable = array('nombre','categoria_id');
    // Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
    protected $hidden = ['created_at','updated_at'];

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function ingresos(){
        return $this->hasMany('App\Ingreso','subcategoria_id');
    }
    public function egresos(){
        return $this->hasMany('App\Egreso','subcategoria_id');
    }
}
