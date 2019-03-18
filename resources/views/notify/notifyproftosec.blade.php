@extends('layouts.masters')
@section('content')
<section class="content">
  <div class="col-md-10">
    @include('flash')
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs"> 
      <li class="active">
        <a href="#tosection" data-toggle="tab">Send to Section</a>
     </li>
      <li>
        <a href="#tostudent" data-toggle="tab">Send to Student</a>
     </li>
     
    </ul>

  <div class="tab-content"> 
    <div class ="active tab-pane" id="tosection">
        
        <div class="box">
         <div class="box-header with-border">
          
            <h3 class="box-title">Send Notification to a Section</h3>
         </div>
        <form action="notifyproftosecs" method="POST">
         <div class="box-body">
          {{ csrf_field() }}
               <div class="form-group">
                 <label class="col-sm-3 control-label">Send to :</label>
                   <div class="col-sm-10">
                    {{Form::select('section',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
                   </div> 
              </div> 
              <div class="form-group"><label class="col-sm-3 control-label">
              Message :</label>
                 <div class="col-md-10">
                  <textarea class="form-control" name="message"></textarea>
                 </div>
              </div>
          </div>
          <div class="box-footer">
             <button type="submit" class="btn btn-primary">Send</button>
         </div>
          </form>
        </div><!--  ito na yung end send to section  -->

   </div> 
   <div class="tab-pane" id="tostudent">
     <div class="box">
         <div class="box-header with-border">
         
            <h3 class="box-title">Send Notification to a Student</h3>
         </div>
        <form action="notifyproftostud" method="POST">
         <div class="box-body">
          {{ csrf_field() }}
               <div class="form-group">
                 <label class="col-sm-3 control-label">Send to:</label>
                   <div class="col-sm-10">
                    {{Form::select('student',$students,null,['class'=>'form-control','placeholder'=>'Please select a Student'])}}
                   </div> 
              </div> 
              <div class="form-group"><label class="col-sm-3 control-label">
              Message :</label>
               <div class="col-md-10">
                 <textarea class="form-control" name="message"></textarea>
               </div>
              </div>
          </div>
          <div class="box-footer">
             <button type="submit" class="btn btn-primary">Send</button>
         </div>
          </form>
        </div><!--  ito na yung end send to student -->



       
  </div>
                        
            
    </div> <!-- TABCONTENT -->
  </div>  <!-- cUSTOM -->
</div>

</section>
        
@stop

