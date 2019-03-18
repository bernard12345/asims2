<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailFollowers extends Mailable
{
    use Queueable, SerializesModels;

    public $followers,$student;
    public $scheds,$attend;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($followers,$student,$scheds,$attend)
    {
        $this->followers = $followers;
        $this->student = $student;
        $this->scheds = $scheds;
        $this->attend = $attend;
        /*return dd($this->followers,$this->student);*/
/*        return dd($this->$scheds); */ 
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.emailfollowers');
    }
}
        
