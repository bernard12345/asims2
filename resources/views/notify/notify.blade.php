@extends('layouts.masters')
@section('content')
<section class="content">
@include('flash')
<div class="box">
  
            
            <div class="box-header with-border">
              <h3 class="box-title">Send Notification</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="/notify" method=POST >
              <div class="box-body">
                {{ csrf_field() }}
                   <div class="form-group">
                    <label class="col-sm-3 control-label">Send to:</label>
                  <div class="col-sm-10">
                  <select name="professor" class="form-control">
                    <option value="">Please Select a Professor</option>
                  @foreach($professors as $prof)
                    <option value="{{ $prof->professor_id }}">{{ $prof->professor_title }} {{ $prof->professor_firstname }} {{ $prof->professor_middlename }}. {{ $prof->professor_lastname }} </option>
                  @endforeach
                  </select>
                  </div>
                
                  </div>
              <div class="form-group">
              <label class="col-sm-3 control-label">You will be:</label>
              <div class="col-sm-10">
                 
                   <select name="option" class="form-control">
                    <option value="">Select an Option</option>
                    <option value="Late">Late</option>
                    <option value="absent">Absent</option> 
                  </select>
                  </div>
              </div>
      
              
             <div class="form-group">
             <label class="col-sm-3 control-label">Reason:</label>
                <div class="col-sm-10">

                    <select name="reason" class="form-control">  
                    <option value="">Select a Reason</option>       
                    <option value="Health">Health</option>
                    <option value="Laziness">Laziness</option> 
                    <option value="Traffic">Traffic</option>             
                    </select>
                  </div>
              </div>
               
                <div class="form-group">
                <label class="col-sm-3 control-label">Specify More information</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="specify"></textarea>
               <!--  <input type="text" class="form-control" name="specify"> -->
                </div>
              </div>
             
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Send</button>
              </div>
            </form>
          </div>
   
      </section>
        
@stop