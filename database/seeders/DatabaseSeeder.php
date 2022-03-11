<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Database\Factories\AdminFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $usuarios = [
            [
                'email' => 'filipe.dbitt@gmail.com',
                'name' => 'Filipe Dias',
                'password' => bcrypt('teste'),
                'document' => '18737575732',
                'spouse_name' => 'FabianyB',
                'spouse_document' => '18737575733'
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::insert($usuario);
        }

    }
}
