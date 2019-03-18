@extends('layouts.masters')
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
  </div>
  <div class="box-body">
 <section class="content">
      <div class="row " >
       @include('Reports.table.studentattend')
      </div>
    </section>
 <div class ="col-md-3"></div>
      <div class="col-md-6">
       <Center><a href = '/download/student/report'><button type="submit" class="btn btn-md btn-primary" >Download Attendance</button></a></Center>    
      </div>  
  </div>
</div>

@stop