<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name        = $this->faker->unique()->name();
        $description = $this->faker->text(rand(255, 5000));
        $users       = User::all();

        return [
            'slug'          => str_replace(' ', '-', $name),
            'name'          => $name,
            'preview'       => substr($description, 0, 255),
            'description'   => $description,
            'owner_id'      => $users[rand(0, count($users) - 1)]->id,
            'has_public'    => 1,
            'created_at'    => date('Y-m-d H:i:s', strtotime('-' . rand(0,5) . 'days'))
        ];
    }
}
