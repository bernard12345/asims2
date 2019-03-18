@extends('layouts.masters')
@section('content')
   <!-- Content Header (Page header) -->
 <section class="content-header">
      <h1>
        View Schedule
        <small>Data</small>
      </h1>
  
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Schedule</h3>
            </div>


            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Section</th>
                  <th>Subject</th>
                  <th>Day</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Term</th>
                  <th>Room</th>

                </tr>
                </thead>
                <tbody>
                
            @foreach($attend as $attendances)
             
                @foreach($attendances->scheduleattendances as $schedule)
                
                    
                <tr>
                <td>{{ $schedule->subject_title }}</td>
                <td>{{ $schedule->subject_code }}</td>
                <td>{{ $attendances->attendance->schedule_day }}</td>
                <td> <a href = "/myattendance/{{ $attendances->attendance->id}}">attendance</td>        
                </tr>
                     
               
                    @endforeach
               
          @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Section</th>
                  <th>Subject</th>
                  <th>Day</th>
                  <th>Start</th>
                  <th>End</th>
                  <th>Term</th>
                  <th>Room</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->



    </section>


  

@stop
 

