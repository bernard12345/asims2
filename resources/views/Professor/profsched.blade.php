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
      @foreach($profsched as $Profsched) 
                @foreach($Profsched->profscheds as $sched)  
                <tr>
                <td>{{ $sched->sections->section_name }}</td>
                <td>{{ $sched->subjects->subject_title }}</td>
                <td>{{ $sched->schedule_day }}</td>
                <td>{{ $sched->schedule_start }}</td>
                <td>{{ $sched->schedule_end }}</td>
                <td>{{ $sched->term }}</td>
                <td>{{ $sched->room_assignment }}</td>              
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
          </div>
        </div>
      </div>
    </section>
@stop
 

