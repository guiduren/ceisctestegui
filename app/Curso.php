<?php

namespace App;

use App\Aula;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    use Notifiable;

    protected $fillable = [
        'nome', 'descricao', 'ativo', 'image','categoria_id',
    ];

   public function aulas()
   {
       return $this->hasMany(Aula::class,'curso_id','id');
   }

    public function categoria()
    {
        return $this->hasOne('App\Categoria','id','categoria_id');
    }
}
