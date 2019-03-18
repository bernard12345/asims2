<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class weeklyReports extends Mailable
{
    use Queueable, SerializesModels;

 
   public $sched,$student;
    public function __construct($sched,$student)
    {
        $this->sched = $sched;
        $this->student = $student;    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.weeklyreports');
    }
}
