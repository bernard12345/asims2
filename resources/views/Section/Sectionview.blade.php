@extends('layouts.masters')
 @section('content')
<section class="content-header">
 <h1>
Manage Sections
</h1>
</section>
<section class="content">
 <div class="row">
  <div class="col-md-12">
   @include('section.crud.secadd') <!-- andito yung mga button  -->
   @include('flash')
  <div class="box">
   <!-- <div class="box-header">
     <h3 class="box-title">Section list</h3>
   </div> -->
    <div class="box-body">
    <table id="example2" class="table table-bordered table-hover text-center">
     <thead><tr>
    
     <th>Course</th>
     <th>Section Name</th>
     <th>Section Year</th>
     <th></th><th></th><th></th></tr>
     </thead>
      <tbody>   
      <?php $df = 7;?>  
      @include('partials.javajs') 
@foreach($Sections as $Section)
<tr> 
                  
<td>{{$Section->courses->course_code}}</td>
<td>
 <a href="#" data-toggle="modal" data-target="#subjectng{{$Section->id}}"> {{ $Section->section_name }}</a>
  <div class="modal fade" id="subjectng{{$Section->id}}">
            <div class="modal-dialog" >
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
       {{ $Section->section_name }}</h4>
    </div> 
        <div class="modal-body">  
          <div >
          <table class="table table-bordered table-hover" style="width:480px;" >
            <thead>
                <tr>
                  <th>Subject</th> 
                  <th>term</th>  
                  <th>batch</th>  
                   <th>delete</th>         
                </tr>
           </thead>
            <tbody>
          <form action="{{url('/subjectdetach')}}" method="POST">
            {{ method_field('POST')}}
            {{ csrf_field() }}
          @if(count($Section->students) > 0)
            @foreach($Section->subjects as $subject) 
            @if($subject->pivot->term == $term->term_code)
            @if($subject->pivot->batch == $term->batch)
                <tr id ="tr{{$subject->id}}"> 
                  <td>{{$subject->subject_title}}</td>         
                  <td>{{$subject->pivot->term}}</td>
                  <td>{{$subject->pivot->batch}}</td>
                  <td><input type="checkbox" name="subjects[{{$subject->id}}]"></td>     
                </tr>
             @endif
             @endif

            
             @endforeach
            @else
              <tr><td>No data Available</td><td>No data Available</td>
              <td>No data Available</td><td>No data Available</td></tr>
             @endif
           </tbody>
           <tfoot>
                <tr>
                 <th>Subject</th> 
                  <th>term</th>  
                  <th>batch</th>  
                  <th>delete</th>           
                </tr>
            </tfoot>
          </table>
          <input type = "hidden" name= "section_id" value ="{{$Section->id}}">
          <div>
            <button type="submit" class="btn btn-block btn-danger btn-lg">
            <i class="fa fa-fw fa-user-plus"></i>Remove Subjects</button>
          </div>
          <form>
       </div>


   </div>
  </div>
</div>
</td>
                  <td>{{$Section->section_year}}</td>
                  <td width="15%"> <a class="btn.btn-app">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$Section->id}}"><i class="fa fa-edit"> View</i></button></a>
                  </td>                  
                  @include('section.crud.secedit')     
                  <td width="15%"><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$Section->id}}">
                  <i class="fa fa-trash"> Delete</i></button></a>
                  </td>                    
                  @include('section.crud.secdel')
                 


                </td>
         </tr>

         <?php $df++;?>
        @endforeach
                </tbody>
                <tfoot>
                <tr>
                
                  <th>Course</th>
                  <th>Section Name</th>
                  <th>Section Year</th>
                   <th></th>
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
@stop
