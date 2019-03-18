@extends('layouts.masters')
@section('content')
<section class="content">
<div class="box box-primary">
  <div class="box-header with-border">
</div>
  <div class="box-body">
 <section class="content">
      <div class="row">
    


@include('Reports.table.today') 




      </div>
</section>

<div class ="col-md-3"></div>
  <div class="col-md-6">
   <center><a href = '/download/report/today'><button type="submit" class="btn btn-md btn-primary" >Download Attendance</button></a></center>
      
  </div>  
</div>
</div>
</section>

@stop