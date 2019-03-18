<form class="form-horizontal" action="professor/{{$professor->id}}" method="POST">  
      
      {{method_field('PATCH')}}
      {{ csrf_field()}}
     
       <div class="form-group">
        <input type="hidden" class="form-control" name="title" id="exampleInputEmail1" value="{{$professor->professor_title}}" >
        <label class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="firstname" placeholder="First Name" value ="{{$professor->professor_firstname }}">
       </div>
       </div>

        <div class="form-group">
         <label  class="col-sm-2 control-label">Middle Initial</label>
         <div class="col-sm-10">
          <input type="text" class="form-control" name="middlename" placeholder="Middle Initial" value ="{{$professor->professor_middlename }}">
         </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Last Name</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="lastname" placeholder="Last Name" value ="{{$professor->professor_lastname }}">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
          <input type="email" class="form-control" name="email" placeholder="Email" value ="{{$professor->professor_email_address }}">
          </div>
        </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Contact</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" name="contact" placeholder="Contact" value ="{{$professor->professor_contact }}">
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Gender</label>
             <div class="col-sm-10">
            {{Form::select('Gender',['Male' => 'Male','Female' => 'Female',],
             $professor->professor_gender,['class' => 'form-control'] )}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Details</label>
              <div class="col-sm-10">
                  <textarea class="form-control" name="details" placeholder="Details">{{$professor['professor_details']}}</textarea> 
              </div>
          </div>
                 
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
           <button type="submit" class="btn btn-danger">Update</button>
          </div>
        </div>
</form>