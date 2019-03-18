@extends('layouts.masters')
@section('content')
<!-- di pa tapos -->
<section class="content">
<div class="row">
  <div class="col-md-12">
   <div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-light-blue-active">
      <div class="widget-user-image">
                  <img class="img-circle" src="/images/{{$student->student_image}}" alt="User Avatar">
      </div>
               
      <h3 class="widget-user-username">{{$student->student_firstname}} {{$student->student_middlename}}.
        {{$student->student_lastname}}</h3>
      <h5 class="widget-user-desc">Student</h5>
 <h5 class="widget-user-desc">
       @if(Auth::user()->followers()->where('student_user.student_id',$student->id)->exists())
       <form action='/unfollow' method="POST">
        {{csrf_field()}}
        <button class="btn btn-lg btn-primary" ><i class="fa fa-check"></i> Following</button>
       
        
        <input type="hidden" value="{{$student->id}}" name="studentids">
        <button type="submit"class="btn btn-lg btn-primary" ><i class="fa fa-times"></i> Unfollow</button>
        </form>
         @else
        <form action='/follow' method="POST">
        {{csrf_field()}}
        <input type="hidden" value="{{$student->id}}" name="studentids">
        <button type="submit"class="btn btn-lg btn-primary" ><i class="fa fa-wifi"></i> Follow</button>
        </form>
       @endif
     </h5>
   </div>

<div class="box-footer no-padding">
 <?php $termlo = array('1st','2nd','3rd')?>
@foreach($arrstu as $arrts)
<div class="col-md-12">
<div class="box-header with-border">
  <h4 class="box-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$arrts}}" aria-expanded="false" class="collapsed">
      {{$arrts}}
    </a>
  </h4>
</div>

<div id="collapseOne{{$arrts}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
  <div class="box-body">
@foreach($termlo as $termlos)
<div class="col-md-12">
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$arrts}}{{$termlos}}" aria-expanded="false" class="collapsed">
        {{$termlos}}
      </a>
    </h4>
  </div>

  <div id="collapseOne{{$arrts}}{{$termlos}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
    <div class="box-body">
      <?php $df = 0;?>
@foreach($student->subjects as $subject)
@if($subject->pivot->term == $termlos)
@if($subject->pivot->batch == $arrts)
<div class="col-md-4"> 
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$arrts}}{{$termlos}}{{$subject->id}}" aria-expanded="false" class="collapsed">
        {{ $subject->subject_title }}
      </a>
    </h4>
  </div>
   <div id="collapseOne{{$arrts}}{{$termlos}}{{$subject->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
    <div class="box-body">
      
@foreach($subject->schedules as $schedule)
  @if($schedule->section_id == $subject->pivot->section_id)
  @if($schedule->term == $termlos)
  @if($schedule->batch == $arrts)
    <h4 >Day : <b>{{$schedule->schedule_day}}</b></h4>
    <h4 >Professor : <b>{{ $schedule->professors->professor_title }}</b> <b>{{ $schedule->professors->professor_firstname }}</b> <b>{{ $schedule->professors->professor_lastname }}</b></h4>
    <h4 ">Time : <b>{{date("h:i A", strtotime($schedule->schedule_start_24))}}</b> - <b> {{date("h:i A", strtotime($schedule->schedule_end_24))}}</b></h4>
    <h4 >Room :<b>{{ $schedule->room_assignment }}</b> </h4>
    <h4 class="title">Section :<a data-toggle="modal" data-target="#modal{{$arrts}}{{$schedule->id}}{{$termlos}}{{$schedule->subject_id}}">{{ $schedule->sections->section_name }}</a></h4>
   
      
         <a href="/attendance/{{$schedule->id}}">   <button type="submit" class="btn btn-md btn-primary" >View Attendance</i></button> </a>  
 
    @include('user.content.studentclassmate')
    @endif
    @endif
  @endif
@endforeach
    </div>
  </div>
</div>
@endif 
@endif
<?php $df++; ?>
@endforeach <!--subject for each-->
    </div> 
  </div>
</div>
@endforeach <!-- term foreach -->
  </div> 
</div>
</div>
@endforeach   <!-- batch for each -->



              


















































</div>
 </div>
 </div> <!-- col 12 -->
</div>     
</section>

@stop