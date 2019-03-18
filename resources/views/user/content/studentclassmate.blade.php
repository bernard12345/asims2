<div class="modal fade" id="modal{{$arrts}}{{$schedule->id}}{{$termlos}}{{$schedule->subject_id}}" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i>
        {{$schedule->sections->section_name}}</h4>
     </div>
        <div class="modal-body"> 
         <table id="example{{$df}}" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
                  <th>Name</th>
                  <th>View</th>     
                </tr>
                </thead>
          <tbody>    
         @foreach($subject->students as $student)
               @if($student->pivot->section_id == $subject->pivot->section_id)
               @if($student->pivot->term == $termlos)
               @if($student->pivot->batch == $arrts) 
               @if($student->pivot->status == "Accept")      
                  <tr> 
                  <td>{{$student->student_id}}</td>         
                  <td><a href ="/studentview/{{$student->id}}">{{$student->student_firstname}} {{$student->student_middlename}}.{{$student->student_lastname}}</a></td>       
                  <td> <a class="btn.btn-app" href ="/attendance/{{$schedule->id}}">
                      <button type="submit" class="btn btn-block btn-primary"> View attendance </button></a>
                  </td> 
                  
                  </tr>
               @endif
               @endif
               @endif
               @endif 
          @endforeach
         </tbody>
            <tfoot>
                <tr>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>View</th>             
                </tr>
            </tfoot>
          </table>      
         </div> <!-- end ng modalbody -->
        </div><!-- end ng modalcontent -->
       </div><!-- dialog modal ng modal -->
      </div> <!-- end ng modal -->
