<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BuildedReportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $result = '';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $result)
    {
        $this->user = $user;
        
        foreach ($result as $item) {
            $this->result .= $this->toHtml($item[0], $item[1]);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('builded_report_user_' . $this->user->id);
    }

    private function toHtml($name, $count) {
        return "<b>$name</b>: <span>$count</span><br>";
    }
}
