<?php

namespace App\Jobs;

use App\Events\SampleEvent;
use App\Mail\InvitedNoneUserMail;
use App\Mail\InvitedUserMail;
use App\Models\ExamRequestUsers;
use App\Services\Org\ExamTargetUserService;
use App\Services\Org\ExamRequestUsersService;
use App\Services\User\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sampleId;

    public $sampleUser;

    /**
     * SendMailJob constructor.
     *
     * @param $sampleId
     * @param $sampleUser
     */
    public function __construct($sampleId, $sampleUser)
    {
        $this->sampleId = $sampleId;
        $this->sampleUser = $sampleUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: sendmail
    }
}
