<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SampleEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Exam request id.
     * @var string
     */
    public $sampleId = '';

    /**
     * List exam target users was created.
     * @var array
     */
    public $sampleUsers = [];

    /**
     * SampleEvent constructor.
     *
     * @param $sampleId
     * @param $sampleUsers
     */
    public function __construct($sampleId, $sampleUsers)
    {
        $this->sampleId = $sampleId;
        $this->sampleUsers = $sampleUsers;
    }
}
