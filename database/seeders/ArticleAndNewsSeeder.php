<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Article;
use App\Models\News;
use App\Models\Tag;

class ArticleAndNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randCount  = rand(20, 60);

        $tags       = Tag::all();
        $articles   = Article::factory()->count($randCount)->create();
        $news       = News::factory()->count($randCount)->create();

        foreach ($articles as $article) {            
            $index  = 0;
            $end    = rand(20, count($tags) - 1);

            foreach ($tags as $tag) {
                
                if ($end <= $index) {
                    $article->tags()->attach($tag->id);
                }
                
                $index++;
            }
        }

        
        foreach ($news as $item) {            
            $index  = 0;
            $end    = rand(20, count($tags) - 1);

            foreach ($tags as $tag) {
                
                if ($end <= $index) {
                    $item->tags()->attach($tag->id);
                }
                
                $index++;
            }
        }
    }
}
