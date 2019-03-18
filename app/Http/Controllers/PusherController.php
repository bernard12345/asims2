<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Student;
 
class PusherController extends Controller
{
 
    public function sendNotification()
    {
        //Remember to change this with your cluster name.
        $options = array(
            'cluster' => 'ap1', 
            'encrypted' => true
        );
       //Remember to set your credentials below.
        $pusher = new Pusher(
            '033a636624d2992694ec',
            '9ed9a6e0438a3d54b889',
            '572649',
            $options); 

    
        $data = 'hello world'; 
        $pusher->trigger('thesis','notify-events', $data);  
    }
}