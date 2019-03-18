@extends('layouts.masters')
@section('content')
<section class="content-header">
  <div class="row">
  <div class="col-xs-12">
   <div class="box">
    <div class="box-body">
 <h3>
Attendance of :
  {{$student->student_firstname}}  {{$student->student_middlename}}. {{$student->student_lastname}}
</h3>
<h4>In Subject : {{ $sched->subjects['subject_title'] }}</h4>
</div>
</div>
</div>
</div>
</section>
<section class="content">
 <div class="row">
  <div class="col-xs-12">
   <div class="box">
    <div class="box-body">
    <table id="example2" class="table table-bordered table-hover">
     <thead><tr>
     <th>Date</th>
     <th>Time In</th>
     <th>Time Out</th>
     <th>Status</th>
     </thead>
      <tbody>      
        @foreach($attendances as $attendance)
         <tr> 
                  <td>{{$attendance->a_date}}</td> 
                  <td>{{$attendance->a_timestamp}}</td>
                  <td>{{$attendance->a_time}}</td>
                  <td>{{$attendance->status}}</td>
                 
         </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                 <th>Date</th>
                 <th>Time In</th>
                 <th>Time Out</th>
                 <th>Status</th>
                </tr>
                </tfoot>
      </table>
      </div>       
   </div>     
  </div>
 </div> 
</section>


@stop
