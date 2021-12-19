<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TagsSynchronizer
{
    public function sync(Collection $tags, Model $model)
    {
        $articleTags = $model->tags->keyBy('name');

        $tags = $tags->keyBy(function($i) { return $i; });

        $syncIds = $articleTags->intersectByKeys($tags)->pluck('id')->toArray();

        $tagsToAttatch = $tags->diffKeys($articleTags);

        foreach ($tagsToAttatch as $tag) {
            $tag = Tag::firstOrCreate(['name' => trim($tag)]);

            $syncIds[] = $tag->id;
        }

        $model->tags()->sync($syncIds);
    }
}
