<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeArticleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $changeFields;
    public $link;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->name         = $article->name;
        $this->link         = "/articles/$article->slug";
        
        $ditryRus = $article->getDitryRus();

        foreach ($ditryRus as &$name) {
            $name = $this->toHtmlBootstrap($name);
        }

        $this->changeFields = implode(', ', $ditryRus);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('updated_article');
    }

    private function toHtmlBootstrap($text) {
        return "<span class=\"badge badge-primary\" style=\"font-size:14px\">$text</span>";
    }
}
