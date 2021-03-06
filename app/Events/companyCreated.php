<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class companyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $company;
    public $country;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($company, $country)
    {
        $this->company = $company;
        $this->country = $country;
    }
}
