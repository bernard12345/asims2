<div class="modal fade" id="modal-default{{$prof->id}}">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span></button>
      <h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i>   DETAILS</a></h4>
       </div>
    <div class="modal-body">
      <form role="form" action="professor/{{$prof->id}}" method="POST">  
          {{ method_field('PATCH') }}
          {{ csrf_field() }}
          
    <div class="box-body">
        <div class="form-group"> <label>ID number</label>
        <input type="text" class="form-control" name="ProfessorId" id="exampleInputEmail1" value="{{$prof->professor_id}}" readonly>
        </div>
        <div class="form-group"><label>Title</label>
         {{Form::select('title',['Mr.' => 'Mr.','Ms.' => 'Ms.','Mrs.' => 'Mrs.','Engr.'=>'Engr.','Dr.'=>'Dr.',],$prof->professor_title,['class' => 'form-control'])}}
        </div>         
        <div class="form-group"><label>First name</label>
        <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ $prof->professor_firstname }}">
        </div>
        <div class="form-group"><label>Last Name</label>
        <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ $prof->professor_lastname }}" >
        </div>
        <div class="form-group"><label>Middle Initial</label>
          <input id="middlename" type="text" class="form-control{{ $errors->has('middlename') ? ' is-invalid' : '' }}" name="middlename" value="{{ $prof->professor_middlename }}"></div>
         <div class="form-group"><label>Gender 
          <div class="radio" style="margin-left:30px;">
           {{  Form::radio('Gender','Male',($prof->professor_gender == 'Male'))}} Male   
          </div>
           <div class="radio" style="margin-left:30px;">   
            {{ Form::radio('Gender','Female',($prof->professor_gender == 'Female'))}} Female
           </div>
            </label>
              </div>
          <div class="form-group"><label>Email</label>
           <input id="email" type="email" class="form-control{{ $errors->has('email') ? 'is-invalid':''}}" name="email" value="{{ $prof-> professor_email_address }}" >
            </div>
           <div class="form-group"><label>Contact</label>
             <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ $prof->professor_contact }}">
             </div>
        </div>                            
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save changes</button>
    
     </div>
   </form>
    </div>
  </div>
</div>
                   