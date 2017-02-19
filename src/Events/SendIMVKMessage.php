<?php

namespace CreateSites\IMVK\Events;

use App\User;
use CreateSites\IMVK\Models\IMVKMessages;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendIMVKMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var object
     */
    public $message;

    /**
     * @var object
     */
    public $from_user;

    /**
     * @var object
     */
    public $for_user;

    /**
     * Create a new event instance.
     *
     * @param $chat
     * @param $user
     */
    public function __construct(IMVKMessages $message, User $from_user, User $for_user)
    {
        $this->message = $message;
        $this->from_user = $from_user;
        $this->for_user = $for_user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['message' . $this->for_user->id];
    }
}