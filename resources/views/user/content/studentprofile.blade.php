<?php use App\term ;?>
<?php $termlo = array('1st','2nd','3rd')?>
<?php $te = Term::where('id',1)->first();?>
@foreach($arrstu as $arrts)
<!-- {{Request::is('student*') ? 'active' : ''}} -->
<div class="col-md-12">
<div class="box-header with-border">
  <h4 class="box-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$arrts}}" aria-expanded="{{ $te->batch == $arrts ? 'true' :'false'}}" >
      {{$arrts}}
    </a>
  </h4>
</div>

<div id="collapseOne{{$arrts}}" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
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
@if($subject->pivot->status == "Accept")
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
    <h4 >Time : <b>{{date("h:i A", strtotime($schedule->schedule_start_24))}}</b> - <b> {{date("h:i A", strtotime($schedule->schedule_end_24))}}</b></h4>
    <h4 >Room :<b>{{ $schedule->room_assignment }}</b> </h4>
    <h4 class="title">Section :<a data-toggle="modal" data-target="#modal{{$arrts}}{{$schedule->id}}{{$termlos}}{{$schedule->subject_id}}">{{ $schedule->sections->section_name }}</a></h4>
   <!--  <form role="form" action="/attendance/student/{{$schedule->id}}" method="POST"> -->
     
            <!-- <input type="hidden" name ="sid" value ="{{$subject->pivot->student_id}}"> -->
        <a href="/attendance/{{$schedule->id}}">    <button type="submit" class="btn btn-md btn-primary" >View Attendance</i></button></a>   
   <!-- </form> -->
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



              











































