<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create()->each(
            function ($user){
                $user->assignRole('admin');
            }
        );

        User::factory(5)->create()->each(
            function ($user){
                $user->assignRole('user');
            }
        );
    }
}
