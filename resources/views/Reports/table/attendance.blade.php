<style>
table.redTable {
  border: 2px solid #0B6FA4;
  background-color: #FFFFFF;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.redTable td, table.redTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.redTable tbody td {
  font-size: 17px;
}
table.redTable tr:nth-child(even) {
  background: #12B9FF;
}
table.redTable thead {
  background: #0B6FA4;
}
table.redTable thead th {
  font-size: 19px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #0B6FA4;
}
table.redTable thead th:first-child {
  border-left: none;
}

table.redTable tfoot {
  font-size: 13px;
  font-weight: bold;
  color: #FFFFFF;
  background: #0B6FA4;
}
table.redTable tfoot td {
  font-size: 13px;
}
table.redTable tfoot .links {
  text-align: right;
}
table.redTable tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #0B6FA4;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
<h2 align = "center">Attendance Report</h2>
<div>
<h4>{{$schedule->subjects['subject_title']}}</h4>
<h4>{{$schedule->sections['section_name']}}</h4>
</div>


<table class="redTable" >
          <thead>
          <tr>
           <th>ID Number</th>
            <th>Name</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>

          @foreach($attendance->subjects['students'] as $attend)

           @if($attendance->section_id == $attend->pivot->section_id)
              <tr> 
                <td>{{$attend->student_id}}</td> 
                <td>{{$attend->student_firstname}} {{$attend->student_lastname}} </td>      
               
                @foreach($attend->attendances as $att)
                  @if($att->student_id == $attend->id && $att->schedule_id == $attendance->id)
                    <td>{{$att['a_date']}}</td>
                    <td>{{$att['a_timestamp']}}</td>
                    <td>{{$att['time']}}</td>
                    <td>{{$att['status']}}</td>
                 @endif
                @endforeach
              </tr>
               
              @endif
            @endforeach
          </tbody>
          <tfoot>
          <tr>
             <th>ID Number</th>
             <th>Name</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </tfoot>
</table>