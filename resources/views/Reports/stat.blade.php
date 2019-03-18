@extends('layouts.masters')
@section('content')

 <section class="content">
 <div class="row " >
     <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>  
                  <th>Section</th>
                </tr>
                </thead>
                <tbody>
              
@foreach($sections as $section)

<tr> 
<td>{{$section->section_name}}</td>
<td>
         <table id="example3" class="table table-bordered table-hover">
            <thead>
            <tr>  
              <th>Subjects</th>
              <th>Present attendance %</th>
              <th>late attendance %</th>
              <th>Absent attendance %</th>
              <th>Present</th>
              <th>Late</th>
              <th>Absent</th>
            </tr>
            </thead>
            <tbody>
                 @foreach($section->schedules as $sched)
                    <tr> 
                    <td>{{$sched->subjects['subject_title']}}</td>
                    <?php $present = 0;
                          $late = 0;
                          $absent = 0;
                     ?>
                @foreach($sched->subjects['students'] as $student)
                  @if($sched->subject_id == $student->pivot->subject_id && $sched->section_id == $student->pivot->section_id)
                    @foreach($student->attendances as $att)
                    @if($sched->id == $att->schedule_id)
                      <?php

                        if($att->status == "PRESENT")
                        {
                          $present++;
                        }
                        elseif($att->status == "LATE")
                        {
                          $late++;
                        }
                        elseif($att->status == "ABSENT")
                        {
                          $absent++;
                        }

                       ?>
                    @endif
                    @endforeach
                  @endif
                @endforeach
                <?php if(!($present == 0))
                      {
                        $rate = (($present /($present + $late + $absent)) * 100 );
                      }
                      else 
                      {
                        $rate = 0.00;
                      } 
                      if(!($late == 0))
                      {
                        $rate1 = (($late /($present + $late + $absent)) * 100 );
                      }
                      else 
                      {
                        $rate1 = 0.00;
                      }
                        if(!($absent == 0))
                      {
                        $rate2 = (($absent /($present + $late + $absent)) * 100 );
                      }
                      else 
                      {
                        $rate2 = 0.00;
                      }












                      ?>
                    <td>{{round($rate,2)}} %</td>
                    <td>{{round($rate1,2)}} %</td>
                    <td>{{round($rate2,2)}} %</td>
                    <td>{{$present}}</td>
                    <td>{{$late}}</td>
                    <td>{{$absent}}</td>

                    </tr>
                  @endforeach
             </tbody>
            <tfoot>
            <tr>
            <tr>  
              <th>Subjects</th>
              <th>Present attendance %</th>
              <th>Late attendance %</th>
              <th>Absent attendance %</th>
              <th>Present</th>
              <th>Late</th>
              <th>Absent</th>
            </tr>
            </tr>
            </tfoot>
         </table>
</td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
  <tr>
  <tr>  
    <th>Section</th>
  </tr>
  </tr>
  </tfoot>
</table>
</div>
</section>
@stop