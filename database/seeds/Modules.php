<?php


use App\ZenSolutions\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Modules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create(
            [
                'name' => 'Grupos',
                'slug' => Str::slug('Grupos'),
                'icon' => 'icon-users',

            ]
        );
        Module::create(
            [
                'name' => 'Usuários',
                'slug' => Str::slug('Usuários'),
                'icon' => 'icon-user',

            ]
        );
        Module::create(
            [
                'name' => 'Clientes',
                'slug' => Str::slug('clientes'),
                'icon' => 'icon-screen-desktop',

            ]
        );

    }
}
