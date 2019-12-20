<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table = 'categorias';
    protected $primaryKey="id";
    protected $fillable = array('nombre','empresa_id');
    protected $hidden = ['created_at','updated_at'];

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
    public function subcategorias(){
        return $this->hasMany('App\Subcategoria', 'categoria_id');
    }
}
