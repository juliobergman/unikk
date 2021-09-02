<?php

namespace App\Listeners;

use App\Models\UserData;
use App\Models\Membership;
use App\Events\userCreated;
use Illuminate\Support\Arr;
use App\Mail\UserCreatedByAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        UserData::create([
            'user_id' => $event->user->id,
            'profile_pic' => '/factory/stock/user-profile.jpg'
        ]);
        Membership::create([
            'user_id' => $event->user->id,
            'company_id' => $event->data->company,
            'job_title' => $event->data->job_title,
            'role' => $event->data->role
            ]);
        $email = array('email' => $event->user->email);
        // Mail::to($email)->send(new UserCreatedByAdmin(urlencode($event->user->temptoken),urlencode($event->user->email)));
    }
}
