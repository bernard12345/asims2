      <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th>
                  <th>Student ID</th>  
    @foreach($student as $Student)

                <tr>    
                <td> 
                 @foreach($Student->attendances as $attend)
                 {{$attend['a_date']}}
                 @endforeach
                </td>
                </tr>

     @endforeach  

     </tr>
     </thead>
     </table>             