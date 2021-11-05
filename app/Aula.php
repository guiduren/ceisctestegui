<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Curso;

class Aula extends Model{

    use Notifiable;

    protected $fillable = [
        'nome', 'descricao', 'disponivel','curso_id',
    ];

    protected $casts = [
        'disponivel' => 'datetime',
    ];

    public function curso()
    {
        return $this->hasOne('App\Curso','id','curso_id');
    }
}
