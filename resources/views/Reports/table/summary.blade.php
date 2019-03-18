 @include('partials.javajs')
<h2 align = "center"><b>Attendance Record</b></h2>
<div class="col-md-6">
<h4><b>Subject   :    </b><br>@foreach($arr['subjectname'] as $subject)
                          {{$subject}}<br>
                        @endforeach</h4>
<h4><b>Section   :    </b>{{$arr['section']}}</h4>
<h4><b>Professor(s) :   </b><br>
  @foreach($arr['profname'] as $prof)
  {{$prof}}<br>
  @endforeach
</h4>
@if(count($pendstud) > 0 )
<button type ="button" id = "verifymodals" class="btn btn-success">Verify Student(s)</button>

<div class="modal fade" id="verifymodal">
  <div class="modal-dialog" >
     <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">×</span></button>
     <h4 class="modal-title">New Student Applying for {{$arr['subjectcode']}} </h4>
     </div>
     <div class="modal-body">
     <button type="button" id="acceptstudentbutton" class ="btn btn-lg btn-success">Accept Student(s)</button>
     <button type="button" id="denystudentbutton" class ="btn btn-lg btn-danger pull-right">Deny Student(s)</button>
          <table class = 'table table-bordered'> 
            <thead>
              <th><input type ="checkbox" id="verifycheck"></th>
              <th>Name Of Student</th>
             </thead>
           @foreach($pendstud as $stud)
            <tr id ="lineaccept{{$stud['id']}}">
              <td><input type ="checkbox" id="verifystu{{$stud['id']}}" value="{{$stud['id']}}"></td>

              <td>{{$stud['name']}}
                <input type="hidden" id ="namepend{{$stud['id']}}" value = "{{$stud['name']}}">
            </td>
            </tr>
            <script>
               
               // $("input:checkbox[id ^= 'verifystu']:checked").map(function(){
               //    if(!(.includes($(this).val()))){

               //                      removestuds.push($(this).val());    
               //        }
               //     });
              

                $("#acceptstudentbutton").hide();
                $("#denystudentbutton").hide();
                 $("input:checkbox[id ^= 'verify']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){  
                        $("#acceptstudentbutton").show();
                        $("#denystudentbutton").show();
                    }
                    else{
                       $("#acceptstudentbutton").hide();
                       $("#denystudentbutton").hide();
                    }
                  }) ;  





            </script>
           @endforeach  
          <script>
             var verify = [];
              $("#acceptstudentbutton").on('click',function(){
                $("input:checkbox[id ^= 'verifystu']:checked").map(function(){
                  if(!(verify.includes($(this).val()))){
                                    verify.push($(this).val());    
                            }
                });
                    $.ajax({
                            url: '/acceptsumstud',
                            type: 'POST',
                            data:{ "section":"{{$arr['section_id']}}",
                                   "term":"{{$arr['term']}}",
                                   "batch":"{{$arr['batch']}}",
                                   "code":"{{$arr['subjectcode']}}",
                                   "stud":verify,
                                  
                                 },
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success:function(req){
                               console.log(req);
                               $.each(verify,function(index,value1){
                                var name ="#namepend"+value1;
                                var html ="";
                                var ns = $(name).val();
                                html ="<tr id=line"+value1+">";
                                html += "<td>"+ns+"</td>";
                                 $.each(req,function(index,value){
                                    console.log(index + "sdf");
                                     $.each(value,function(key,laman){
                                        console.log(laman['id'] + "sdfsdfs");
                                        console.log(laman['date'] + "sdfsdfs");
                                        var html1 = "";
                                        var modal = "#modaltable"+laman['date']+laman['id'];
                               
                             html1 =  "<tr id ="+value1+"line2"+laman['id']+laman['date']+">";
                             html1 += "<td><input type='checkbox' id = check"+laman['id']+laman['date']+value1+" value ="+value1+"/></td>";
                             html1 += "<input type='hidden' id=student"+value1+" value ="+value1+"/>";
                             html1 += "<input type='hidden' id=date"+laman['date']+value1+" value ="+value1+"/>";
                             html1 += "<td>"+ns+"</td>";
                             html1 += "<td><select id=status"+laman['id']+laman['date']+value1+" class='form-control'><option value =''>No status</option>";
                             html1 += "<option value='PRESENT'>PRESENT</option><option value='LATE'>LATE</option><option value='ABSENT'>ABSENT</option></select></td>";
                            html1 +="</tr>";
                            console.log(modal);
                            console.log(html1);
                            $(modal).prepend(html1);
                                     html += "<td align ='center' id ="+laman['id']+"-"+laman['date']+"-"+value1+"></td>";
                                     
                                     });
                                 

                                 });
                                     html += "</tr>";
                                 console.log(html);
                                      $("#maintable1").prepend(html);
                               });
                               
                            },error:function(){ 
                                alert("error occurred");
                            }
                         });










                $("#verifymodal").modal('hide');

                console.log(verify);
              });



               $("#denystudentbutton").on('click',function(){
                $("input:checkbox[id ^= 'verifystu']:checked").map(function(){
                  if(!(verify.includes($(this).val()))){
                                    verify.push($(this).val());    
                            }
                });
                 $("#verifymodal").modal('hide');

                  
                   $.ajax({
                            url: '/denysumstud',
                            type: 'POST',
                            data:{ "section":"{{$arr['section_id']}}",
                                   "term":"{{$arr['term']}}",
                                   "batch":"{{$arr['batch']}}",
                                   "code":"{{$arr['subjectcode']}}",
                                   "stud":verify,
                                  
                                 },
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success:function(req){
                               console.log(req);
                                 $.each(req,function(index,value){
                                 var sd = "#lineaccept"+value;
                            
                                 $(sd).remove();
                                 });
                                var def = "{{count($pendstud)}}" 
                                var df = req.length 
                                def = def - df ;
                                if(def == 0){
                                  $("#verifymodals").hide();
                                }
                                verify = []
                            },error:function(){ 
                                alert("error occurred");
                            }
                         });
              
              });
                           /*chcheck lhat ng checkbox*/
                  //   $("input:checkbox[ id ^= 'verify']").prop("checked", $(this).prop("checked"));
                             
                  // });
          </script>
            
            </table>   
                  </div>        
               </div>
             </div>
             
</div>
<script>
  $("#verifymodals").on('click',function(){
     $("#verifymodal").modal('show');
  });
</script>
@endif
</div>

<div class="col-md-6" style="float:right;">
  <h4><b>Term:</b>{{$arr['term']}}</h4>
  <h4><b>Batch:</b>{{$arr['batch']}}</h4>
  <h4><b>Room(s):</b><br>@foreach($arr['room'] as $room ) {{$room}}<br>@endforeach</h4>
  <h4><b>Schedule(s):</b><br>@foreach($arr['start'] as $key => $value )
                <b> {{$arr['scheduleday'][$key]}}                  :        {{date("h:i A", strtotime($arr['start'][$key]))}}</b> to <b>{{date("h:i A", strtotime($arr['end'][$key]))}} </b> <br>
                            @endforeach</h4>
</div>

<div class="modal fade" id="removes">
            <div class="modal-dialog" ">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title">Student list</h4>
                 </div>
                  <div class="modal-body">
                    <button type="button" id="removestudentbutton" class ="btn btn-primary">Remove Student(s)</button>
          <table class = 'table table-bordered'> 
            <thead>
              <th><input type ="checkbox" id="removeallcheck"></th>
              <th>Name Of Student</th>
             </thead>
           @foreach($studatt as $student)
            <tr id ="line3{{$student['id']}}">
              <td><input type ="checkbox" id="removecheck{{$student['id']}}" value="{{$student['id']}}"></td>
              <td>{{$student['name']}}</td>

            </tr>
            <script>
                 $("#removeallcheck").on('change',function(){
                           /*chcheck lhat ng checkbox*/
                    $("input:checkbox[ id ^= 'removecheck']").prop("checked", $(this).prop("checked"));
                           
                  });
                 
              
              $("#removestudentbutton").hide();
                $("input:checkbox[id ^= 'removeallcheck']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){  
                       $("#removestudentbutton").show();
                    }
                    else{
                     $("#removestudentbutton").hide();
                    }
                  }) ;  
               $("input:checkbox[id ^= 'removecheck']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){  
                       $("#removestudentbutton").show();
                    }
                    else{
                     $("#removestudentbutton").hide();
                    }
                  }) ;  
             </script>

            @endforeach  
            <script>
              
              $("#removestudentbutton").on('click',function(){
                var removestuds = [];
                 $("input:checkbox[id ^= 'removecheck']:checked").map(function(){
                     
                      if(!(removestuds.includes($(this).val()))){

                                    removestuds.push($(this).val());    
                      }
                  });
                  console.log(removestuds);
 
                  var  term = "{{$arr['term']}}";
                  var  section = "{{$arr['section_id']}}";
                  var  batch = "{{$arr['batch']}}";
                  var  code = "{{$arr['subjectcode']}}";



                  if(confirm("Are You sure you want to continue to Delete this Student(s)")){
                      $.ajax({
                            url: '/removesumstud',
                            type: 'POST',
                            data:{"term":term,
                                   "section":section,
                                   "batch":batch,
                                   "code":code,
                                   "student":removestuds,
                                  
                                 },
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success:function(doc){
                              $("#removes").modal('hide');
                              $.each(doc,function(index,value){
                                var a = "#line"+value;
                                var sd ="#line3"+value;
                              
                                $(sd).remove();
                                $(a).remove();
                                @foreach($studatt as $student)
                                  if(value == "{{$student['id']}}"){
                                    @foreach($student['attendance'] as $attend)
                                      var as= "#"+value+"line2{{$attend['attendancesched'].$attend['attendancedate']}}" ;
                                     
                                      $(as).remove();
                                    @endforeach
                                  }
                                 
                                @endforeach
                              });
                                
                            },error:function(){ 
                                alert("error occurred");
                            }
                         });
                    
                  }
                  else{console.log("trues");}
              });
            </script>
            
            </table>   
                  </div>        
               </div>
             </div>
             
  </div>

<table class = 'table table-bordered' id = "maintable1">
  <thead>
    <th class="text-center"><a href="#" data-toggle="modal" data-target="#removes">Name</a></th>
     
    @foreach($week as $wek => $value)
    <th colspan = "{{count($value)}}" class="text-center"> <a href="#" data-toggle="modal" data-target="#{{$wek}}">{{$wek}}</a></th>
    @endforeach
  </thead>
@foreach($studatt as $student)
  <tr id = "line{{$student['id']}}">
        <td>{{$student['name']}}</td>  
        @foreach($student['attendance'] as $attend)
        
           @if($attend['attendancestatus'] == 'PRESENT')
                    <td align="center" id="{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}">
                      <font  ><b style="color:#4682B4;">P </b></font>
                    </td>
                    @elseif($attend['attendancestatus'] == 'LATE')
                    <td align="center" id="{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}"><b style="color:#FF8C00;">L</b></font></td>
                    @elseif($attend['attendancestatus'] == "ABSENT")
                    <td align="center" id="{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}"><b style="color:red;">A</b></font></td>
                    @elseif($attend['attendancestatus'] == "N")
                    <td align="center" id="{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}"><b style="color:black;">N</b></font></td>
                    @else
                     <td align="center"id="{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}"><b style="color:red;"></b></font></td>
                    @endif
       
        @endforeach 
 </tr>
@endforeach
</table>
@foreach($week as $wek => $value)
  <div class="modal fade" id="{{$wek}}">
            <div class="modal-dialog" style="width:380px;">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title">{{$wek}} Meeting(s)</h4>
                 </div>
                  <div class="modal-body">
         <?php $a = 1;?>
         @foreach($value as $val)
                    
          <button type="button" data-toggle="modal" data-target="#button{{$wek}}{{$val['date']}}"class="btn btn-success"> Meeting{{$a}}({{$val['date'] }})</button> 
                     <?php $a++;?>
                   @endforeach
                 </div>        
               </div>
             </div>
  </div>




   @foreach($value as $val)
                    
      <div class="modal fade" id="button{{$wek}}{{$val['date']}}">
            <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title">{{$wek}} Meeting(s)</h4>
                 </div>
                  <div class="modal-body">
                    <div class = "col-md-12">
                    <select id = "dropdownall{{$val['id']}}{{$val['date']}}" class="form-control">
                      <option value="">No Status</option>
                      <option value ="PRESENT">PRESENT</option>
                      <option value ="LATE">LATE</option>
                      <option value ="ABSENT">ABSENT</option>
                    </select>
                  </div>
                  
                  <tr id = "{{$student['id']}}line2{{$val['id'].$val['date']}}">

                  <br>
                   <table class="table table-bordered" id ="modaltable{{$val['date']}}{{$val['id']}}">
                    <thead>
                        @if(Auth::user()->roles == 2 || Auth::user()->roles == 1)
                          <th><input type="checkbox" id="checkall{{$val['date']}}{{$val['id']}}" name="bakit"></th>
                        @endif
                      <th>Name</th>
                      <th>Status</th>
                    </thead>
                  @foreach($studatt as $student)
                    <tr id = "{{$student['id']}}line2{{$val['id'].$val['date']}}">
                      <td><input type="checkbox" id="check{{$val['id']}}{{$val['date']}}{{$student['id']}}" value="{{$student['id']}}" name="bakit"></td>
                      <td>{{$student['name']}}</td>
                      @foreach($student['attendance'] as $attend)
                             @if($val['id'] == $attend['attendancesched'] && $val['date'] == $attend['attendancedate'])
                      <td>
                      <input type="hidden" id ="student{{$student['id']}}" value="{{$student['id']}}" name="id{{$student['id']}}">
                      <input type="hidden" id ="date{{$attend['attendancedate']}}{{$student['id']}}" value="{{$attend['attendancedate']}}" name="date{{$student['id']}}">
                     {{Form::select('status',[''=>'No status','PRESENT' => 'PRESENT','LATE' => 'LATE','ABSENT' => 'ABSENT',],$attend['attendancestatus'],['id'=>'status'.$attend['attendancesched'].$attend['attendancedate'].$student['id'],'class' => 'form-control'])}}
                     </td >   
                      <script>
                        var chec =[];
                          $("#dropdownall{{$val['id']}}{{$val['date']}}").on('change',function(){
                      //dropdown kapag nag change
                            var statuscheck = $(this).val();
                            $("input:checkbox[id ^= 'check{{$val['id']}}{{$val['date']}}']:checked").map(function(){

                               
                            if($("#student{{$student['id']}}").val() ==  $(this).val() ){
                                $("#status{{$val['id'].$val['date'].$student['id']}}").val(statuscheck);

                                 if(statuscheck == "PRESENT"){
                                    
                                     $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:#4682B4;">P </b></font>')
                                $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");
                                  }
                                  else if(statuscheck == "LATE"){
                                    
                                   $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:#FF8C00;">L</b></font>')
                              $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("{{$attend['attendancedate']}}");
                                  }
                                  else if(statuscheck == "ABSENT"){
                                    
                                       $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:red;">A</b></font>')
                                 $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");
                                  }
                                  else{
                                     $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font></font>')
                                 $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");

                                  }

                            }
                                if(!(chec.includes($(this).val()))){
                                    chec.push($(this).val());    
                                }
                                
                            });
                            
                           
                            console.log(chec,statuscheck+"{{$val['id']}}"+"consolelog");
                       
                          $.ajax({
                            url: '/updateatt',
                            type: 'POST',
                            data:{"schedule":"{{$val['id']}}",
                                   "status":statuscheck,
                                   "date":"{{$val['date']}}",
                                   "stud":chec,
                                  
                                 },
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success:function(req){
                             
                                console.log(req);
                                
                            },error:function(){ 
                                alert("error occurred");
                            }
                         });
                        
                    });

                     $("#checkall{{$val['date'].$val['id']}}").on('change',function(){
                           /*chcheck lhat ng checkbox*/
                    $("input:checkbox[ id ^= 'check{{$val['id']}}{{$val['date']}}']").prop("checked", $(this).prop("checked"));
                           
                    });
                   $("input:checkbox[id ^= 'check{{$val['id']}}{{$val['date']}}']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){
                      
                       $("#dropdownall{{$val['id']}}{{$val['date']}}").show();
                       
                    }
                    else{
                      
                     $("#dropdownall{{$val['id']}}{{$val['date']}}").hide();
                                          }
                  }) ;            
                 $("input:checkbox[id ^= 'checkall{{$val['date']}}{{$val['id']}}']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){
                      
                       $("#dropdownall{{$val['id']}}{{$val['date']}}").show();
                       
                    }
                    else{
                      
                     $("#dropdownall{{$val['id']}}{{$val['date']}}").hide();
                                          }
                  }) ;             

                $("#dropdownall{{$val['id']}}{{$val['date']}}").hide();
                $("#status{{$attend['attendancesched'].$attend['attendancedate'].$student['id']}}").on('change', function() {
                        
                        console.log('testing');
                        var ids = "{{$attend['attendancesched']}}";
                        var statuss =  $(this).val();
                        var dates = "{{$attend['attendancedate']}}"
                        var studs = $('#student{{$student["id"]}}').val();
                         console.log(ids+statuss +dates +" "+studs);
                         

                          $.ajax({
                          url: '/updatekona',
                          type: 'POST',
                          data:{"schedule":ids,
                                 "status":statuss,
                                 "date":dates,
                                 "stud":studs,
                                
                               },
                          headers: {
                              'X-CSRF-TOKEN': "{{ csrf_token() }}"
                          },
                          success:function(req){
                            
                              if(req.status == "PRESENT"){
                                
                                $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:#4682B4;">P </b></font>')
                                $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");
                              }
                              else if(req.status == "LATE"){
                                
                              $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:#FF8C00;">L</b></font>')
                              $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("{{$attend['attendancedate']}}");
                              }
                              else if(req.status == "ABSENT"){
                                
                                 $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font><b style="color:red;">A</b></font>')
                                 $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");
                              }
                              else{
                                $("##{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").html('<font></font>')
                                 $("#{{$attend['attendancesched']}}-{{$attend['attendancedate']}}-{{$student['id']}}").addClass("table{{$attend['attendancedate']}}");

                              }
                              
                              
                          },error:function(){ 
                              alert("error occurred");
                          }
                       });
                         
                        



                    });
                $("#button{{$wek}}{{$val['date']}}").on('click',function(){
                   $("#{{$wek}}").modal('hide');
                    $("#week{{$wek}}{{$val['date']}}").modal('show');
                   
                });
            </script>
                            @endif

      

                            <!-- script -->
                      @endforeach
                    </tr>
                  @endforeach
                  </table>
                 </div>        
               </div>
             </div>
           </div>

          
            @endforeach
@endforeach


