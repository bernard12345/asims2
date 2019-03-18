<div class="col-md-3">
  <h3 class="box-title">
  <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal-default01"><i class="fa fa-fw fa-user-plus"></i>
   ADD NEW STUDENT</button>
  </h3>
</div>
<div class="col-md-4">
  <h3 class="box-title">
  <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#substudent"><i class="fa fa-fw fa-user-plus"></i>
   ADD SUBJECT TO STUDENT</button>
  </h3>
</div>

<div class="col-md-4">
  <h3 class="box-title">
  <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#import"><i class="fa fa-fw fa-user-plus"></i>
  Export Students</button>
  </h3>
</div>


<div id="import" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
        EXPORTS STUDENTS</h4>
    </div> 
        <div class="modal-body">  
       
        <div class="form-group">
          
          <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                  <th>Section</th> 
                  <th></th>         
                </tr>
           </thead>
            <tbody>
           
              
            @foreach($section as $sect) 
                <tr> 
                  <td>{{$sect->section_name}}</td>
                <td>
               <form role="form" action="/exportstudents" method="POST"> 
                 {{ csrf_field() }}
                <input type="hidden" value="{{$sect->id}}" name="section_ids">
                <button type="submit" class="btn btn-primary pull-left" style="width:80%">Export</button></td>  
                </form>     
                </tr>
            @endforeach
           </tbody>
           <tfoot>
                <tr>
                  <th>Sections</th>
                  <th></th>  
                </tr>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
        <a class="btn.btn-app" href="/exportstudentss">
        <button type="submit" class="btn btn-primary btn-lg">Export all Students</button></a>
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        </div>
     
        </div>
   </div>
  </div>
</div>




 <!-- assign ng subjects modal -->
<div class="modal fade" id="substudent" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span></button>
  <h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i>
  ASSIGN STUDENT TO SUBJECTS</h4>
      </div>
      <div class="modal-body">  
        <form role="form" action="/addstudentsubject" method="POST"> 
        {{ csrf_field() }}
         <div class="form-group"><label>Student</label>s
          <!-- <select  class="form-control select2 select2-hidden-accessible" > -->
             <select class="form-control" name="stud_id">
              <option value= "">Please select a Student</option>
                @foreach($Students as $student)
                    <option value="{{ $student->id }}">
                      {{ $student->student_firstname }} {{ $student->student_lastname }}
                    </option>  
                @endforeach
            </select>
        </div>

        <div class="form-group"><label>Section</label>
         {{Form::select('secids',$Sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
        </div>

       <table id="secsub" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Subject</th>

            <th><center><button type="button" name="addRows" class="btn btn-primary btn-sm" id="addRows"><i class="glyphicon glyphicon-plus"></i></button></center></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td style="width:75%;">
            <div class="form-group">
            {{Form::select('subid[]',$subjects,null,['class'=>'form-control','placeholder'=>'Please select a Subject'])}}
            </div>
          </td>
          <td></td>
          </tr>
        </tbody>
      </table>
        <div class="modal-footer">
        <a class="btn.btn-app">
        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
  </div>
</div>
</div>


<!-- student add sa baba nito -->

<div class="modal fade" id="modal-default01" style="display: none;" width="100%">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
    ADD NEW STUDENT</h4>
    </div>
   <div class="modal-body">
    <form role="form" action="/student" method="POST"> 
       {{ csrf_field() }}
        <div class="box-body">                 
         <div class="form-group"><label>Student ID</label>
          <input  type="text" class="form-control{{ $errors->has('stid') ? ' is-invalid' : '' }}" name="stid" value="{{ old('stid') }}">
        </div>
       
        <div class="form-group"><label>First Name</label>
        <input  type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}">
        </div>
        <div class="form-group"><label>Middle Initial</label>
         <input  type="text" class="form-control{{ $errors->has('mname') ? ' is-invalid' : '' }}" name="mname" value="{{ old('mname') }}">
         </div>
         <div class="form-group"><label>Last Name</label>
         <input  type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}">
          </div>
          <div class="form-group"><label>Contact</label>
          <input  type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ old('contact') }}">
          </div>
          <div class="form-group"><label>Email</label>
           <input  type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
          </div>
          <div class="form-group"><label>Address</label>
          <input  type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}">
          </div>        
           <div class="form-group"><label>Gender</label>
            {{Form::select('gender', ['Male' => 'Male','Female' => 'Female',],null,['class' => 'form-control'])}}
          </div>
           <div class="form-group"><label>Status</label>
            {{Form::select('status', ['Enabled' => 'Enabled','Disabled' => 'Disabled',
              ],null,['class' => 'form-control'])}}
           </div>
        </div>
         <div class="modal-footer"><button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
         <a class="btn.btn-app"><button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
          </div>
        </form>            
        </div>                      
      </div>                                
    </div>
</div>

