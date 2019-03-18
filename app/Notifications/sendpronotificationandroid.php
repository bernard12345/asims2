<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notify;

class sendpronotificationandroid extends Notification
{
    use Queueable;
    public $notifys;
    public function __construct($notifys)
    {
        $this->notifys = $notifys;
        //return dd($notifys);
       // chincheck lng kung napasa ba tlaga yung data
    } 
    public function via($notifiable)
    {      
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {      
        
        return [         
                'sender'=>$this->notifys['sender'],
                'sender_id'=>$this->notifys['sender_id'],
                'status'=>$this->notifys['option'],
                'reason'=>$this->notifys['reason'],
                'specify'=>$this->notifys['specify']       
         ];
        
    }
}
