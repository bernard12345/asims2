<html>
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

<h2 align= "center" >
  Attendance Report
</h2>


<h4>ID Number: {{$student['student_id']}}</h4>
<h4>Name: {{$student['student_firstname']}} {{$student['student_lastname']}}</h4>

<table class="redTable">
          <thead>
          <tr>
            <th>ID Name</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($attendance as $attend)
              <tr> 
                <td>{{$attend->students['student_id']}}</td> 
                <td>{{$attend['a_date']}}</td>
                <td>{{$attend['a_timestamp']}}</td>
                <td>{{$attend['time']}}</td>
                <td>{{$attend['status']}}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
          <tr>
             <th>ID Name</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
          </tr>
          </tfoot>
</table>
</html>