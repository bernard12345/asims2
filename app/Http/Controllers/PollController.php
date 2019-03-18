<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poll;
class PollController extends Controller
{
    public function index()
    {
    	$poll = Poll::all();
    	return view('Poll.view',compact('poll'));
    }
}
