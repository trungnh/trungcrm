<?php

namespace App\Listeners;

use App\Events\SampleEvent;
use App\Jobs\SendMailJob;
use App\Mail\InvitedNoneUserMail;
use App\Mail\InvitedUserMail;
use App\Models\ExamRequestUsers;
use App\Services\Org\ExamTargetUserService;
use App\Services\Org\ExamRequestUsersService;
use App\Services\User\UserService;

class SampleSendMailListener
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
     * @param  SampleEvent  $event
     * @return void
     */
    public function handle(SampleEvent $event)
    {
        $this->sendMail($event->sampleId, $event->sampleUsers);
    }

    /**
     * Send mail
     * @param $sampleId
     *
     * @param $sampleUsers
     */
    private function sendMail($sampleId, $sampleUsers)
    {
        dispatch(new SendMailJob($sampleId, $sampleUsers));
    }
}
