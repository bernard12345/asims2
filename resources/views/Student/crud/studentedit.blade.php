<td><a class="btn.btn-app">
<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$Student->id}}"><i class="fa fa-edit"> View</i></button></a></td> 

<div class="modal fade" id="modal-default{{$Student->id}}">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span></button>
  <h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i> STUDENT DETAILS</a></h4>
      </div>
      <div class="modal-body">
       <form role="form" action="student/{{$Student->id}}" method="POST">  
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="box-body">
          <div class="form-group"><label>Student ID</label>
         <input  type="text" class="form-control{{ $errors->has('stid') ? ' is-invalid' : '' }}" name="stid" value="{{$Student->student_id}}" readonly>
          </div>
         
          <div class="form-group"><label>Section</label>
          {{-- {{Form::select('section_id','$Sections',$Student->section_id,
           ['class'=>'form-control'])}} --}}
          </div>
          <div class="form-group"><label>First Name</label>
            <input  type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{$Student->student_firstname}}">
          </div>
          <div class="form-group"><label>Middle Name</label>
            <input  type="text" class="form-control{{ $errors->has('mname') ? ' is-invalid' : '' }}" name="mname" value="{{$Student->student_middlename}}">
          </div>
          <div class="form-group"><label>Last Name</label>
            <input  type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{$Student->student_lastname}}">
          </div>
          <div class="form-group"><label>Contact</label>
            <input  type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{$Student->student_contact}}">
          </div>
          <div class="form-group"><label>Email</label>
            <input  type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$Student->student_email_address}}">
          </div>
          <div class="form-group"><label>Address</label>
            <input  type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{$Student->student_address}}">
          </div>
          <div class="form-group"><label>Gender</label>
            {{Form::select('gender', ['Male' => 'Male','Female' => 'Female',],$Student->gender,['class' => 'form-control'])}}
          </div>
          <div class="form-group"><label>Status</label>
            {{Form::select('status', ['Enabled' => 'Enabled','Disabled' => 'Disabled',],$Student->status,['class' => 'form-control'])}}
          </div>
        </div> <!-- body --> 
      </div><!-- modal body --> 
       <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>   
        </form>
     </div>   
  </div>                      
</div>                                
</div>
                      