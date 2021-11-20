<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUsers();
    }

    public function seedUsers()
    {
        $roleAdmin = Role::create(['name' => 'Администратор', 'prefix' => 'admin']);
        $roleAuthor = Role::create(['name' => 'Автор', 'prefix' => 'author']);

        $user = User::create(
            [
                'name'      => 'Administrator Site',
                'email'     => env('MAIL_ADMIN', 'voranasyerdnov@gmail.com'),
                'password'  => Hash::make('qwerty12345'),
            ]
        );

        $user->roles()->attach($roleAdmin->id);

        
        $user = User::create(
            [
                'name'      => 'Test Author',
                'email'     => 'test@tt.tt',
                'password'  => Hash::make('qwerty12345'),
            ]
        );

        $user->roles()->attach($roleAuthor->id);

        $this->call([
            UserSeeder::class,
            ArticleSeeder::class
        ]);
    }
}
