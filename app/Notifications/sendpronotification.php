<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notify;

class sendpronotification extends Notification
{
    use Queueable;
    public $notifys;
    public function __construct($notifys)
    {
        $this->notifys = $notifys;
        
    } 
    public function via($notifiable)
    {      
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {      
        
        return [         
                'sender'=>auth()->user()->name,
                'sender_id'=>auth()->user()->id,
                'status'=>$this->notifys->option,
                'reason'=>$this->notifys->reason,
                'specify'=>$this->notifys->specify       
         ];
        
    }
}
