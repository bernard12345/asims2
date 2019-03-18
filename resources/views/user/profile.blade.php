 <?php
    use App\Student;
    use App\Professor;
    $as = Student::where('student_id',Auth::user()->secondary_id)->first();
    $pro =Professor::where('professor_id',Auth::user()->secondary_id)->first();
    if($as){
        $name = $as->student_firstname." ". $as->student_middlename." ".$as->student_lastname;
    }
    elseif($pro){
     $name = $pro->professor_firstname." ". $pro->professor_middlename." ".$pro->professor_lastname;
    }
    else{
    $name = Auth::user()->name;
    }
 ?>
@extends('layouts.masters')
@section('content')
<section class="content">
<div class="row">
<div class="col-md-12">
 @auth
<div class="box box-widget widget-user">
  <div class="widget-user-header bg-light-blue-active">
   <!-- ipapakita lng yung details ng nag log in -->
  
    <h3 class="widget-user-username">{{$name}}</h3>
    <h5 class="widget-user-desc">{{Auth::user()->role->role_name}}</h5>
  </div>
  <div class="widget-user-image">
  <img class="img-circle" src="../images/{{ Auth::user()->avatar }}" alt="User Avatar">
  </div>
  
  <div class="box-footer">
     <div class="row">
                  <div class="description-block">
                  @if(Auth::user()->roles == 3 or Auth::user()->roles == 2)
                  <h5 class="description-header">
                    ID Number : {{Auth::user()->secondary_id}}
                  </h5>
                  @endif
                  <span class="description-text"></span>
                  </div>          
      </div>
  </div>
</div>
 {{-- @include('user.content.profiledet') --}}<!-- details ng profile di pa naayos  -->
 @endAuth
      <div class="col-md-12">
          @include('flash')
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @if(Auth::user()->roles <= 3 && Auth::user()->roles >= 2)
              <li class = "active">
              <a href="#mysubjects" data-toggle="tab">My Subjects</a>
              </li>
              @endif
              @if(Auth::user()->roles != 2 )
              <li>
              <a href="#mystudents" data-toggle="tab">Students List</a>
              </li>
              @endif
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
             @if(auth::user()->roles > 3)
              <li><a href="#link" data-toggle="tab">link your account</a></li>
             @endif
             <li><a href="#avatar" data-toggle="tab">Avatar</a></li>
             @if(auth::user()->provider == NULL)
             <!-- <li><a href="#avatar" data-toggle="tab">change Password</a></li> -->
             @endif
            </ul>
            <div class="tab-content">
             
              <!-- /.tab-pane -->
              


               @if(Auth::user()->roles == 2)
                <div class ="tab-pane active" id="mysubjects">
                    <div class="panel">
                      <div class="panel-body ">
                 @include('user.content.professorprofile')
                 </div>
                 </div>
                </div>
                @elseif(Auth::user()->roles == 3)
               
                 <div class ="tab-pane" id="mysubjects">
                    <div class="panel">
                      <div class="panel-body ">
                    @include('user.content.studentprofile')</div>
                   </div>
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
           
            @foreach($Students as $Stude)
              <tr> 
              <td width="20%" align="center">
                   <img class="img-circle" src="../images/{{$Stude->student_image}}" alt="{{$Stude->student_image}}" style="width:90px;" align="center"></td>         
              <td><h4><a href ="/studentview/{{$Stude->id}}">{{$Stude->student_firstname}} {{$Stude->student_middlename}}.{{$Stude->student_lastname}}</a></h4></td>
             
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




<div class="tab-pane" id="profiledit">
               @if(Auth::user()->roles == 2)
               @include('user.content.profilepro')
               @elseif(Auth::user()->roles == 3)
               @include('user.content.profilestud')
               @endif
  </div>
  <div class="tab-pane" id ="avatar">
              @include('user.content.changepic') 
    </div>


@if(Auth::user()->roles == 3)
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

 @if(auth::user()->roles > 3)
<div class="tab-pane" id="link">
    
     <h3 class="box-title">Link your Account</h3>
        <form action="/linkmyacc" method="POST">
         <div class="box-body">
          {{ csrf_field() }}
          <div class="form-group">
              Insert Your ID Number:
                  <input class="form-control" name="secondary_id">
          </div>
          </div>
          <div class="box-footer">
              <button type="submit" class="btn btn-lg btn-primary">LINK</button>
          </div>
         
          </form>

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
      <td><h4><a href ="/studentview/{{$follows->id}}">{{$follows->student_firstname}} {{$follows->student_middlename}} {{$follows->student_lastname}}</a></h4></td>            
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
  <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>

  

</div>
</section>

 

@stop