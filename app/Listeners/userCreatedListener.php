<?php

namespace App\Listeners;

use App\Models\UserData;
use App\Events\userCreated;
use App\Mail\UserCreatedByAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;

class userCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  userCreated  $event
     * @return void
     */
    public function handle(userCreated $event)
    {



        UserData::create(['user_id' => $event->user->id]);

        $email = array('email' => $event->user->email);
        // Mail::to($email)->send(new UserCreatedByAdmin(urlencode($event->user->temptoken),urlencode($event->user->email)));
    }
}
