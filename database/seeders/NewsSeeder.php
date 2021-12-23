<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randCount  = rand(20, 60);

        $news = News::factory()->count($randCount)->create();

    }
}
