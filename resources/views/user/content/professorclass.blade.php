

       
                     <!--  link papunta dapat doon sa list ng student per section -->    
  <div class="modal fade" id="modal-default{{$schedule->section_id}}{{$arrts}}{{$termlos}}{{$schedule->subject_id}}" style="display: none;">
    <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">×</span></button>
     <h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i>
      {{ $schedule->sections['section_name'] }}</h4>
      </div>
        <div class="modal-body"> 
         <table id="example{{$df}}" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
                  <th>Name</th>
                  <th></th>     
                </tr>
                </thead>
          <tbody>    
              @foreach($schedule->subjects['students'] as $student )
               @if($schedule->section_id == $student->pivot->section_id)  
               @if($student->pivot->term == $termlos)
               @if($student->pivot->batch == $arrts)  
                  <tr> 
                  <td>{{$student->student_id}}</td>         
                  <td><a href ="/studentview/{{$student->id}}">{{$student->student_firstname}} {{$student->student_middlename}}.{{$student->student_lastname}}</a></td>       
                  <td> <a class="btn.btn-app">
                  <form action="/studsubattend" method ="POST">
                  {{csrf_field()}}
                  
                  <input type="hidden" name ="studentid" value ="{{$student->id}}">
                  <input type="hidden" name = "schedid" value="{{$schedule->id}}">
                  <button type="submit" class="btn btn-block btn-primary"> View attendance </button></a>
                  </td> 
                  </form>
                  </tr>
                  @endif
                  @endif
                @endif 
              @endforeach 
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


