@extends('layouts.masters')
 @section('content')
    <section class="content-header">
      <h1>
        Manage Students
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
                 @include('student.crud.studentadd')  
            </div>
          </div>
                 @include('flash') 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Student list</h3>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
<tbody>            
@foreach($Students as $Student)
                  <tr> 
                  <td>{{$Student->student_id}}</td>         
                  <td><h4><a href ="/studentview/{{$Student->id}}">{{$Student->student_firstname}} {{$Student->student_middlename}}.{{$Student->student_lastname}}</a></h4></td>
                  <td>{{$Student->gender}}</td>
                  @include('student.crud.studentedit')                   
                  @include('student.crud.studentdel')
                  <td><a class="btn.btn-app">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#sub{{$Student->id}}"><i class="fa fa-edit">View Subjects</i>
                  </button></a>

                <div id="sub{{$Student->id}}" class="modal fade">
                  <div class="modal-dialog">
                   <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">×</span></button>
                       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
                       {{$Student->student_firstname}} {{$Student->student_middlename}}.{{$Student->student_lastname}}</h4>
                    </div> 
                        <div class="modal-body">  
                          <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                  <th>Student ID</th> 
                                  <th></th>
                                
                                       
                                </tr>
                           </thead>
                            <tbody>
                            <form action="/studentsubdetach" method="POST">
                              {{ csrf_field() }}
                            @foreach($Student->subjects as $subject) 
                                <tr> 
                                  <td>{{$subject->subject_title}}</td>       
                                  <td>
                                    <input type="hidden" name="stds_id" value= "{{$Student->id}}">
                                    <input type="checkbox" name="subjects[{{$subject->id}}]">
                                  </td>
                                </tr>
                            @endforeach
                           </tbody>
                           <tfoot>
                                <tr>
                                  <th></th> 
                                  <th>Name</th>
                                  
                              
                                        
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                        <div class="modal-footer">
                        <a class="btn.btn-app">
                        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-block btn-primary">SAVE</button></a>
                        </div>
                      </form>
                    </div>
                   </div>
                  </div> <!-- end ng subject view modal -->
</td>
</tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
            </div>           
          </div>  
        </div> 
      </div>    
    </section>
@include('partials.javajs')

<script>
  $(document).ready(function() {
    $(document).on('click', '#addRows', function() {
      var html = '';
      html += '<tr>';
      html += '<td style="width:75%;">{{Form::select("subid[]",$subjects,null,["class"=>"form-control","placeholder"=>"Please select a Subject "])}}';
      html += '<td><center><button type="button" name="removeRows" class="btn btn-danger btn-sm" id="removeRows"><i class="glyphicon glyphicon-minus"></i></button></center></td></tr>';
      $('#secsub').append(html);
    });

    $(document).on('click', '#removeRows', function() {
      $(this).closest('tr').remove();
    });
  });
</script>


@endsection