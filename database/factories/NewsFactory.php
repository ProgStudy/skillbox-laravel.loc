<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name        = $this->faker->unique()->name();
        $description = $this->faker->text(rand(255, 5000));

        return [
            'slug'          => str_replace(' ', '-', $name),
            'name'          => $name,
            'preview'       => substr($description, 0, 255),
            'description'   => $description,
            'created_at'    => date('Y-m-d H:i:s', strtotime('-' . rand(0,5) . 'days'))
        ];
    }
}
