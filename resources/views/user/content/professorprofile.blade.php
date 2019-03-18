  <!--  kapag prof yung nakita role -->
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
  @foreach($professor->schedules as $schedule)
  @if($schedule->term == $termlos)
  @if($schedule->batch == $arrts)
  <div class="col-md-4">
 <div class="box-header with-border">
  <h4 class="box-title">
   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$arrts}}{{$termlos}}{{$schedule->id}}" aria-expanded="false" class="collapsed">{{ $schedule->subjects->subject_title }}</a>
 </h4>
</div>
<div id="collapseOne{{$arrts}}{{$termlos}}{{$schedule->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
  <div class="box-body">
     <h4 >Day : <b>{{$schedule->schedule_day}}</b></h4>
  <h4>Time : <b>{{date("h:i A", strtotime($schedule->schedule_start_24))}}</b> - <b> {{date("h:i A", strtotime($schedule->schedule_end_24))}}</b></h4>
   <h4>Room:<b>{{ $schedule->room_assignment }}</b></h4>
   <h4>Section : <b><a data-toggle="modal" data-target="#modal-default{{$schedule->section_id}}{{$arrts}}{{$termlos}}{{$schedule->subject_id}}"> {{ $schedule->sections['section_name'] }}</a></b>
   </h4>
    <form action = "/summary" method ="POST">
      {{csrf_field()}}
          <input type = "hidden" name ="section_id" value = "{{$schedule->section_id}}">
          <input type = "hidden" name ="term" value = "{{$schedule->term}}">
          <input type = "hidden" name ="batch" value = "{{$schedule->batch}}">
          <input type = "hidden" name ="subject_code" value = "{{$schedule->subjects->subject_code}}">
          
          
            <button type="submit" class="btn btn-block btn-primary" >View Summary</i></button>
         
      
    </form>
    <a class="btn.btn-app" href="/attendance/{{$schedule->id}}">   

          
            <button type="button" class="btn btn-block btn-primary" >View Records</i></button>
     </a>
          
   
      @include('user.content.professorclass')
    </div>
  </div>
</div> <!-- col md 4 -->
<?php $df++; ?>
  @endif
  @endif
  @endforeach
        </div>
      </div>
    </div> <!-- col md 12 -->
    @endforeach
  </div>
</div>
</div> <!-- col md 12 -->
@endforeach


  