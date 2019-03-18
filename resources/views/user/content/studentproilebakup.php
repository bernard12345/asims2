<!--  kapag student yung nakita role -->
<div class = "col-md-4">
<div class="box box-solid">
 <div class="box-header with-border">
     <h3 class="box-title">My Subjects</h3>
 </div>
<div class="box-body">
     @foreach($student->subjects as $subject)
  <div class="box-group" id="accordion">

 

<div class="panel box box-primary">
 <div class="box-header with-border">
  <h4 class="box-title">
   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$subject->id}}" aria-expanded="false" class="collapsed">{{ $subject->subject_title }}</a>
 </h4>
</div>
<div id="collapseOne{{$subject->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
  <div class="col-md-12">
  <div class="box-body">
   

@foreach($subject->schedules as $schedule)
    @if($schedule->section_id == $subject->pivot->section_id)
    <h4 >Day : <b>{{$schedule->schedule_day}}</b></h4>
    <h4 >Professor : <b>{{ $schedule->professors->professor_title }}</b> <b>{{ $schedule->professors->professor_firstname }}</b> <b>{{ $schedule->professors->professor_lastname }}</b></h4>
    <h4 ">Time : <b>{{date("h:i A", strtotime($schedule->schedule_start_24))}}</b> - <b> {{date("h:i A", strtotime($schedule->schedule_end_24))}}</b></h4>
   
   <h4 >Room :<b>{{ $schedule->room_assignment }}</b> </h4>
     <h4 class="title">Section :<a data-toggle="modal" data-target="#modal{{$schedule->subject_id}}"> {{ $schedule->sections->section_name }}</a></a></h4>

      <form role="form" action="/attendance/student/{{$schedule->id}}" method="POST">
      {{csrf_field()}}
      <td><a class="btn.btn-app">

            <input type="hidden" name ="sid" value ="{{$subject->pivot->student_id}}">
            <button type="submit" class="btn btn-md btn-primary" >View Attendance</i></button>
          </a>
      </td>
      </form>

  <div class="modal fade" id="modal{{$schedule->subject_id}}" style="display: none;">
   <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">×</span></button>
     <h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i>
      {{$schedule->sections->section_name}}</h4>
      </div>
        <div class="modal-body"> 
         <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
                  <th>Name</th>
                  <th></th>     
                </tr>
                </thead>
          <tbody>    
        
         </tbody>
            <tfoot>
                <tr>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th></th>             
                </tr>
            </tfoot>
          </table>      
         </div> <!-- end ng modalbody -->
        </div><!-- end ng modalcontent -->
       </div><!-- dialog modal ng modal -->
      </div> <!-- end ng modal -->
    @endif
    @endforeach <!-- mga kumukuha ng subject na to-->            
     </div>
    </div>
   </div> <!-- end ng collapse -->
  </div>
 @endforeach<!-- unang loop kunin yung lahat subject ng student
-->
  </div>
 </div><!-- end ng box body ng collapse -->
</div>  
</div>





<div class="nav-tabs-custom">
    <ul class="nav nav-tabs"> 
     
      
     @if(Auth::user()->roles <= 3 && Auth::user()->roles >= 2)
      <li class="active">
        <a href="#mysubjects" data-toggle="tab">My Subjects</a>
     </li>
 
     @endif
     <li>
        <a href="#mystudents" data-toggle="tab">Students List</a>
     </li>

    @if(Auth::user()->roles == 3)
     <li>
        <a href="#myfollowers" data-toggle="tab">Followers</a>
     </li>
     
     @endif
      <li>
        <a href="#myfollowings" data-toggle="tab">Followings</a>
     </li>
     @if(Auth::user()->roles == 3 or Auth::user()->roles == 2 )     
      <li><a href="#profiledit" data-toggle="tab">Edit Profile</a></li>
     @endif
      <li><a href="#avatar" data-toggle="tab">Avatar</a></li>
    </ul>

  <div class="tab-content">  
      @if(Auth::user()->roles == 2)
      <div class ="tab-pane" id="mysubjects">
         @include('user.content.professorprofile')<!-- kapag professor nag login -->
       </div>
      @elseif(Auth::user()->roles == 3)
       <div class ="tab-pane" id="mysubjects">
         @include('user.content.studentprofile')
       </div>
      @endif
       <div class="tab-pane" id="mystudents">        
             <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Student ID</th> 
                      <th>Name</th>
                    </tr>
                    </thead>
            <tbody>            
            @foreach($Students as $Student)
              <tr> 
              <td>{{$Student->student_id}}</td>         
              <td><h4><a href ="/studentview/{{$Student->id}}">{{$Student->student_firstname}} {{$Student->student_middlename}}.{{$Student->student_lastname}}</a></h4></td>
             
              </tr>
             @endforeach
            </tbody>
            <tfoot>
            <tr>
              <th>Student ID</th>
              <th>Name</th>            
            </tr>
            </tfoot>
            </table>
  </div> 
@if(Auth::user()->roles == 3)
<!-- makikita ng student yung mga naka follow sa kanaya mga users  -->
<div class="tab-pane" id="myfollowers">
 
<table id="example3" class="table table-bordered table-hover">
 <thead>
  <tr>
    <th>Image</th>
    <th>Name</th>
  </tr>
 </thead>
<tbody>            
   @foreach($student->followers as $follow)
    <tr> 
      <td width="20%" align="center">
      <img class="img-circle" src="../images/{{$follow->avatar}}" alt="User Avatar" style="width:90px;" align="center">
      </td> 
      <td><h4>{{$follow->name}}</h4></td>         
     
    </tr>
  @endforeach
</tbody>
    <tfoot>
    <tr>
    <th>Image</th>
    <th>Name</th>
    </tr>
    </tfoot>
</table>
</div>
@endif
<div class="tab-pane" id="myfollowings">
  <table id="example4" class="table table-bordered table-hover">
 <thead>
  <tr>
    <th>Image</th>
    <th>Name</th>
  </tr>
 </thead>
<tbody>         
   @foreach(Auth::user()->followers as $follows)
    <tr> 
      <td width="20%" align="center">
      <img class="img-circle" src="../images/{{$follows->student_image}}" alt="User Avatar" style="width:90px;" align="center">
      </td> 
      <td><h4><a href ="/studentview/{{$Student->id}}">{{$follows->student_firstname}} {{$follows->student_middlename}} {{$follows->student_lastname}}</a></h4></td>            
    </tr>
  @endforeach
</tbody>
    <tfoot>
    <tr>
    <th>Image</th>
    <th>Name</th>
    </tr>
    </tfoot>
</table>




</div>
  <div class="tab-pane" id="profiledit">
               @if(Auth::user()->roles == 2)
               @include('user.content.profilepro')
               @elseif(Auth::user()->roles == 3)
               @include('user.content.profilestud')
               @endif
  </div>
              @include('user.content.changepic')              
            
</div> <!-- TABCONTENT -->







   </div>  <!-- cUSTOM -->