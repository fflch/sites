<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Site extends Model
{

    use HasFactory;

    public function scopeAllowed($query)
    {
        $user = Auth::user();
        if (!Gate::allows('admin')) {
            $query->OrWhere('owner', '=', $user->codpes);
            // melhorar essa query!!! está insegura
            $query->OrWhere('numeros_usp', 'LIKE', '%'.$user->codpes.'%');
            return $query;
        }
        return $query;
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function responsavel(){
        return $this->belongsTo('App\Models\User', 'owner', 'codpes');
    }

    public static function categorias() {
    return [
            'Grupo de estudo',
            'Grupo de pesquisa',
            'Departamento',
            'Administrativo',
            'Centro',
            'Associação',
            'Laboratório',
            'Comissão',
            'Evento',
            'Programa de Pós-Graduação'
        ];
    }

    public static function status() {
        return [
                'Aprovado - Habilitado',
                'Aprovado - Desabilitado',
                'Solicitado',
            ];
        }
}
