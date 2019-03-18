@extends('layouts.masters')

 @section('content')
 


  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal-default01"><i class="fa fa-fw fa-user-plus"></i>
                    ADD NEW SCHEDULE
              </button></h3>
              {{-- Add Schedule modal --}}
                          <div class="modal fade" id="modal-default01" style="display: none;">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
                                      ADD NEW SCHEDULE</h4>
                                  </div>
                                  <div class="modal-body">
                                          <form role="form" action="/schedule" method="POST"> 
                                        @csrf
                              
                                          <div class="box-body">
                                           
                                           <div class="form-group">
                                              <label>Professor</label>

                                            {{Form::select('profname',
                                            $Professors,null,['class'=>'form-control'])}}
                                           
                                            </div> 
                                         
                                         
                                          
                                           <div class="form-group">
                                              <label>Subject</label>

                                            {{Form::select('subject',
                                            $Subjects,null,['class'=>'form-control'])}}
                                           
                                            </div> 

                                            <div class="form-group">
                                              <label><strong>Section</strong></label>

                                            {{Form::select('section',$Sections,null,['class'=>'form-control'])}}
                                           
                                            </div>
                                            <div class="form-group">
                                              <label>Day</label>
                                            {{Form::select('day', [
                                               'Monday' => 'Monday',
                                               'Tuesday' => 'Tuesday',
                                               'Wednesday' => 'Wednesday',
                                               'Thursday' => 'Thursday',
                                               'Friday' => 'Friday',
                                               ],null,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div>


                                            <div class="form-group">
                                              <label>Start Time</label>
                                                <input  type="time" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" value="{{ old('start') }}">
                                                            @if ($errors->has('start'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('start') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>
                                            <div class="form-group">
                                              <label>Start End</label>
                                                <input  type="time" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" name="end" value="{{ old('end') }}">
                                                            @if ($errors->has('end'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('end') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>

                                           <div class="form-group">
                                              <label>Term</label>
                                            {{Form::select('term', [
                                               '1st' => '1st',
                                               '2nd' => '2nd',
                                               '3rd' => '3rd',
                                               ],null,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                            <div class="form-group">
                                              <label>Batch</label>
                                                <input  type="month" class="form-control{{ $errors->has('batch') ? ' is-invalid' : '' }}" name="batch" value="{{ old('batch') }}">
                                                            @if ($errors->has('batch'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('batch') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>

                                             <div class="form-group">
                                              <label>Status</label>
                                            {{Form::select('status', [
                                               'Not Started' => 'Not Started',
                                               'Started' => 'Started',
                                               ],null,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                            <div class="form-group">
                                              <label>Room</label>
                                              {{Form::select('room', [
                                               'Aquarium Room' => 'Aquarium Room',
                                               'COET Laboratory Room' => 'COET Laboratory Room',
                                               'I.T. Laboratory Room' => 'I.T. Laboratory Room',
                                               ],null,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                    

                                      </div>
                                      

                                          <!-- /.box-body -->

                                          <div class="box-footer">
                                            
                                            
                                          </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
                                    
                                    <a class="btn.btn-app"><button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
                                  </div>
                                  
                            </form>
                                  



                             
                                  </div>
                             
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                          </div>
            </div>
            <!-- /.box-header -->
                
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Schedule list</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
               
                  <th>Professor Name</th>
                  <th>Section</th>
                  <th>Subject</th>
                  <th>Schedule Day</th>
                  <th>Start time</th>
                  <th>End time</th>
                

                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                
               @foreach($Schedules as $Schedule)
                  <tr> 
                  <td>{{$Schedule->professors->professor_title}} {{$Schedule->professors->professor_firstname}} {{$Schedule->professors->professor_middlename}}. {{$Schedule->professors->professor_lastname}}    </td>
                  <td>{{$Schedule->sections->section_name}}</td>
                  <td>{{$Schedule->subjects->subject_title}}</td>
                  <td>{{$Schedule->schedule_day}}</td>
                  <td>{{$Schedule->schedule_start}}</td>
                  <td>{{$Schedule->schedule_end}}</td>
                     <td> <a class="btn.btn-app">
                   <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$Schedule->id}}"><i class="fa fa-edit"> View</i></button></a></td>

                   <!-- sa baba ito yung modal ng update -->
                    <div class="modal fade" id="modal-default{{$Schedule->id}}">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                  <h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i> SCHEDULE DETAILS</a></h4>
                                </div>
                                <div class="modal-body">
 <form role="form" action="schedule/{{$Schedule->id}}" method="POST">  
                                  @method('PATCH')
                                  @csrf
                                
                                        <div class="box-body">
                                            <div class="form-group">
                                              <label>Professor</label>

                                            {{Form::select('profname',
                                            $Professors,$Schedule->professor_id,['class'=>'form-control'])}}
                                           
                                            </div> 
                                         
                                         
                                          
                                           <div class="form-group">
                                              <label>Subject</label>

                                            {{Form::select('subject',
                                            $Subjects,$Schedule->subject_id,['class'=>'form-control'])}}
                                           
                                            </div> 

                                            <div class="form-group">
                                              <label><strong>Section</strong></label>

                                            {{Form::select('section',$Sections,$Schedule->section_id,['class'=>'form-control'])}}
                                           
                                            </div>
                                            <div class="form-group">
                                              <label>Day</label>
                                            {{Form::select('day', [
                                               'Monday' => 'Monday',
                                               'Tuesday' => 'Tuesday',
                                               'Wednesday' => 'Wednesday',
                                               'Thursday' => 'Thursday',
                                               'Friday' => 'Friday',
                                               ],$Schedule->schedule_day,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div>


                                            <div class="form-group">
                                              <label>Start Time</label>
                                                <input  type="time" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" value="{{ $Schedule->schedule_start }}">
                                                            @if ($errors->has('start'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('start') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>
                                            <div class="form-group">
                                              <label>Start End</label>
                                                <input  type="time" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" name="end" value="{{ $Schedule->schedule_end }}">
                                                            @if ($errors->has('end'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('end') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>

                                           <div class="form-group">
                                              <label>Term</label>
                                            {{Form::select('term', [
                                               '1st' => '1st',
                                               '2nd' => '2nd',
                                               '3rd' => '3rd',
                                               ],$Schedule->term,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                            <div class="form-group">
                                              <label>Batch</label>
                                                <input  type="month" class="form-control{{ $errors->has('batch') ? ' is-invalid' : '' }}" name="batch" value="{{ $Schedule->batch }}">
                                                            @if ($errors->has('batch'))
                                                                <div class="form-group has-error">
                                                                          <span class="help-block"><strong>{{ $errors->first('batch') }}</strong></span>
                                                                      </div>   
                                                            @endif
                                            </div>

                                             <div class="form-group">
                                              <label>Status</label>
                                            {{Form::select('status', [
                                               'Not Started' => 'Not Started',
                                               'Started' => 'Started',
                                               ],$Schedule->status,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                            <div class="form-group">
                                              <label>Room</label>
                                              {{Form::select('room', [
                                               'Aquarium Room' => 'Aquarium Room',
                                               'COET Laboratory Room' => 'COET Laboratory Room',
                                               'I.T. Laboratory Room' => 'I.T. Laboratory Room',
                                               ],$Schedule->room_assignment,['class' => 'form-control']
                                              )}}
                                           
                                           
                                            </div> 
                                    
                                            </div>


                                          
                                         
                                            
                                            
                                            <!-- /.box-body -->

                                        
                                
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                  </div>
                                  </form>
                                  
                                  </div>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                   
              <!-- sa taas ito yung modal ng update -->

  <!-- sa baba ito yung modal ng delete -->
                  <td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$Schedule->id}}">
                  <i class="fa fa-trash"> Delete</i></button></a></td>         
                              <div class="modal modal-danger fade" id="modaldanger{{$Schedule->id}}" style="display: none;">
                                <div class="modal-dialog" style="margin-top:300px;">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                      <h4 class="modal-title">DELETE !!!</h4>
                                    </div>
                                    <div class="modal-body">
                                      <p>Are you sure you want to delete  <b>Schedule</b> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                      <form role="form" action="Schedule/{{$Schedule->id}}" method="POST"> 
                                      @method('DELETE')
                                      @csrf
                                      <button type="submit" class="btn btn-outline">Delete</button>
                                      </form>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
          <!-- /.modal-dialog -->
                            </div>
                             <!-- sa taas ito yung modal ng delete -->

                </tr>

 

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Professor Name</th>
                  <th>Section</th>
                  <th>Subject</th>
                  <th>Schedule Day</th>
                  <th>Start time</th>
                  <th>End time</th>

                  <th></th>
                  <th></th>
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
    <!-- /.content -->

  <!-- /.content-wrapper -->
 

@stop