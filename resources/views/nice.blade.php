      <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
    @foreach($attendance as $Attendance)

                  <tr>    
                  <td>{{$Attendance->students['student_firstname']}}</td>
                  </tr>
     @endforeach  

     </tr>
     </thead>
     </table>             