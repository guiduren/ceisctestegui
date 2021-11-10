<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    use Notifiable;

    protected $fillable =[
        'nome',
    ];

    public function cursos()
    {
        return $this->hasMany('App\Cursos','categoria_id','id');
    }

}



