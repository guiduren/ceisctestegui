<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model{

    use Notifiable;

    protected $fillable = [
        'nome', 'descricao', 'ativo','image',
    ];

}
