<?php

use Illuminate\Database\Seeder;




class AulasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aulas')->insert([
            'nome' => "Juridico",
            'descricao' => "Descrição do curso de Juridico",
            'disponivel' => now(),
            'created_at' => now(),
        ]);

       DB::table('aulas')->insert([
           'nome' => "Portugues",
           'descricao' => "Descrição do curso de Portugues",
           'disponivel' => now(),
           'created_at' => now(),
        ]);
    }
}
