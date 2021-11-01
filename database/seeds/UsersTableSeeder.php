<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "adm@ceisc.com.br",
            'password' => \Hash::make('secret'),
        ]);

        factory(App\User::class, 50)->create();
    }
}
