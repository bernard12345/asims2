@extends('layouts.masters')
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
</div>
  <div class="box-body">
 <section class="content">
      <div class="row " >
        <form role="form" action="/attendance/{{$id}}" method="POST">
          {{csrf_field()}}
        <div class="form-group">
          <label>Date</label>
          <input type='date' name='date' id = 'date'  value = "{{$d}}">
         <button type="submit" class="btn btn-md btn-primary" >Search</button>
          </div>
      </form>
        @include('Reports.table.attendance')
      </div>
    </section>
 
       <center><a href = '/download/report'><button type="submit" class="btn btn-md btn-primary" >Download</button></a><ceter>
  </div>
</div>
@stop