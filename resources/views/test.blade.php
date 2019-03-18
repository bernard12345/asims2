      <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Student ID</th> 
    @foreach($student as $Student)

                  <tr>    
                  <td>{{$Student->sections['section_name']}}</td>
                  </tr>
     @endforeach  

     </tr>
     </thead>
     </table>             