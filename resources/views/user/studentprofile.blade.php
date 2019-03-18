      
@extends('layouts.masters')
@section('content')
<section class="content">
<div class="row">
<div class="col-md-12">
            @auth
            <div class="box box-widget widget-user">
            <div class="widget-user-header bg-light-blue-active">
              <h3 class="widget-user-username">{{Auth::user()->name}}</h3>
              <h5 class="widget-user-desc">{{Auth::user()->role->role_name}}</h5>
            </div>
            <div class="widget-user-image">
            <img class="img-circle" src="../images/{{ Auth::user()->avatar }}" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                  <div class="description-block">
                  <h5 class="description-header">ID Number : {{Auth::user()->secondary_id}}</h5>
                  <span class="description-text"></span>
                  </div>          
            </div>
            </div>
            </div>
         @include('user.content.profiledet')
         @endAuth
      
<div class="col-md-9">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs"> 
      <li class="active"><a href="#mysubjects" data-toggle="tab">My Subjects</a></li>
      <li><a href="#timeline" data-toggle="tab">Schedule</a></li>
             @if(Auth::user()->roles == 3 or Auth::user()->roles == 2)     
               <li><a href="#profiledit" data-toggle="tab">Edit Profile</a></li>
             @endif
              <li><a href="#avatar" data-toggle="tab">Avatar</a></li>
    </ul>

  <div class="tab-content"> 
      <div class ="active tab-pane" id="mysubjects">
          @if(Auth::user()->roles == 3)
          <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">My Subjects</h3>
                  </div>
              <div class="box-body">
                <div class="box-group" id="accordion">
                      @foreach($student->subjects as $subject)
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $subject->id}}" aria-expanded="false" class="collapsed">
                              {{ $subject->subject_title }}
                            </a>
                          </h4>
                        </div>
              <div id="collapseOne{{ $subject->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
             <div class="box-body">
                         Schedule lagay dito
              </div>
              </div>
                      </div>
                      @endforeach
                </div>
              </div>
          </div>  
                @endif  
        </div> 
    
              <div class="tab-pane" id="profiledit">
               @if(Auth::user()->roles == 2)
               @include('user.content.profilepro')
               @elseif(Auth::user()->roles == 3)
               @include('user.content.profilestud')
               @endif
              </div>

  <div class="tab-pane" id="avatar">
      <form class="form-horizontal" action="user/{{Auth::user()->id}}"  method="POST" enctype="multipart/form-data">
       {{csrf_field()}}
       {{method_field('PUT')}}
       <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Avatar</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name="image" id="inputName" placeholder="Name" >
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" class="btn btn-danger">Submit</button>
         </div>
        </div>
      </form>
   </div>
              
            
         </div> <!-- TABCONTENT -->
         </div>  <!-- cUSTOM -->
</div>
</div>
</section>
    <!-- /.content -->

@stop