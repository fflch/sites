<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{

    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario');
    }

    public function site(){
        return $this->belongsTo('App\Models\Site');
    }

    public function files_chamado(){
        return $this->hasMany('App\Models\FilesChamado');
    }
    
    public static function status(){
        return [
          'aberto',
          'fechado'
        ];
    }
}
