<form class="form-horizontal" action="student/{{$student->id}}" method="POST">  
      {{ method_field('PATCH')}}
      {{csrf_field()}}
    <div class="form-group">
      <!-- wlang kwenta laman -->
      <input type="hidden" class="form-control" name="role_id" id="exampleInputEmail1" value="{{$student->role_id}}" >
      <input type="hidden" class="form-control" name="section_id"  value="{{$student->section_id}}" >
      <input type="hidden" class="form-control" name="status" id="exampleInputEmail1" value="{{$student->status}}" > 
       <label class="col-sm-2 control-label">ID</label>
         <div class="col-sm-10">
         <input type="text" class="form-control" name="stid" placeholder="First Name" value ="{{$student->student_id}}" readonly>
       </div>
    </div>
      <div class="form-group"><label class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="fname" placeholder="First Name" value ="{{$student->student_firstname }}">
        </div>
      </div>
      <div class="form-group"><label  class="col-sm-2 control-label">Middle Initial</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mname" placeholder="Middle Initial" value ="{{$student->student_middlename }}">
        </div>
     </div>
     <div class="form-group"><label f class="col-sm-2 control-label">Last Name</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" name="lname" placeholder="Last Name" value ="{{$student->student_lastname }}">
      </div>
     </div>
    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
       <input type="email" class="form-control" name="email" placeholder="Email" value ="{{$student->student_email_address }}">
      </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Contact</label>
     <div class="col-sm-10">
       <input type="text" class="form-control" name="contact" placeholder="Contact" value ="{{$student->student_contact }}">
     </div>
    </div>
  <!--   <div class="form-group"><label class="col-sm-2 control-label">Pin</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" maxlength="6" name="pin" placeholder="pin number" value ="{{$student['pin']}}">
      </div>
    </div> -->
    <div class="form-group"><label class="col-sm-2 control-label">Address</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" name="address" placeholder="Contact" value ="{{$student->student_address }}">
      </div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Gender</label>
      <div class="col-sm-10">
      {{Form::select('gender',['Male' => 'Male','Female' => 'Female',],$student->gender,['class' => 'form-control'])}}
      </div>
    </div>
    <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-danger">Update</button>
     </div>
   </div>
</form>