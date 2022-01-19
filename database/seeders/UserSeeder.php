<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randCount  = rand(1, 20);
        $tags       = Tag::all();
        $users      = User::factory()->count(2)->create();

        foreach ($users as $user) {
            $user->roles()->attach(2);
        }

        $users = User::all();

        foreach ($users as $user) {
            $index  = 0;
            $end    = rand(20, count($tags) - 1);

            foreach ($tags as $tag) {
                
                if ($end <= $index) {
                    $user->tags()->attach($tag->id);
                }
                
                $index++;
            }
        }
    }
}
