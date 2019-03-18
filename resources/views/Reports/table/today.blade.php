<?php use App\Professor;?>
@include('partials.javajs')
<h2 align = "center"><b>Attendance Record</b></h2>
<div class="col-md-6">
<h4><b>Subject :    </b>{{$schedule->subjects['subject_title']}}</h4>
<h4><b>Section :    </b>{{$schedule->sections['section_name']}}</h4>
<h4><b>Professor:   </b>
  {{$schedule->professors['professor_title']}}
  {{$schedule->professors['professor_firstname']}}
  {{$schedule->professors['professor_lastname']}}
</h4>
</div>
<div class="col-md-6" style="float:right;">
  
  <h4><b>Term:</b>{{$schedule->term}}</h4>
  <h4><b>Batch:</b>{{$schedule->batch}}</h4>
  <?php $profes = Professor::where('professor_id',Auth::user()->secondary_id)->first();?>

  @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
  <form role="form" action="/addattendance" method="POST">
    {{ csrf_field() }}
  <h4><b>Add Attendance:  
    <input type="hidden" name="sched" value= "{{$schedule->id}}">
   
    <button type="submit" name="" class="btn btn-primary btn-sm" id="addRows"><i class="glyphicon glyphicon-plus"></i></button>
  
  </h4>
  </form>
   @if(count($pending) > 0)
     <button type="button" id="pending"  data-toggle="modal" data-target="#pendingla" class="btn btn-success">Verify Student(s)</button> 
     @endif
           <div class="modal fade" id="pendingla">
            <div class="modal-dialog" >
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title">Verify Students</h4>
                 </div>
                  <div class="modal-body">
            <button type="button"  id="acceptmainto"class="btn btn-lg btn-primary pull-left" data-toggle="modal" data-target="#acceptmainto1">Accept Student(s)</button>
            <button type="button" id="removemainto" class="btn btn-lg btn-danger pull-right" data-toggle="modal" data-target="#removemainto1">Deny Student(s)</button> 
                   <table class="table table-bordered table-hover" style="margin-top:50px;">
                    <tr>
                      <th><input type = "checkbox" id="checkpendall"></th>
                      <th class="text-center">Name of Student</th>
                      
                    </tr>
                    
                    @foreach($pending as $student)
                    <tr>
                    <td ><input type = "checkbox" name="checkpend" id="checkpends{{$student->id}}[]" value ="{{$student->id}}"></td>
                    <td width="95%" align="center">{{$student->student_lastname}} ,{{$student->student_firstname}} {{$student->student_middlename}}</td>  
                    </tr>
                    @endforeach 
                    </table>

           <div class="modal fade" id="acceptmainto1">
            <div class="modal-dialog" style="width:280px;">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title"></h4>
                 </div>
                  <div class="modal-body">
                   Are you sure you want to ACCEPT all the checked students ?
                 </div>
                 <div class="modal-footer">
                  <button type="button" id ="acceptcancel" class="btn btn-primary pull-left">Cancel</button> 
                  <button type="button" id="acceptmain"class="btn btn-success pull-right">ACCEPT Student(s)</button> 
                 </div>
               </div>
             </div>
           </div>
           <div class="modal fade" id="removemainto1">
            <div class="modal-dialog" style="width:280px;">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title"></h4>
                 </div>
                  <div class="modal-body">
                   Are you sure you want to REMOVE all the checked students ?
                 </div>
                 <div class="modal-footer">
                  <button type="button" id ="removecancel"class="btn btn-primary pull-left" >Cancel</button> 
                  <button type="button" id="removemain"class="btn btn-danger pull-right">Deny Student(s)</button> 
                 </div>
               </div>
             </div>
           </div>

                    <script>
                      $("#acceptmain").on('click',function(){

                          var pendcheck = [];
                           $("input:checkbox[id ^= 'checkpends']:checked").map(function(){
                                if(!(pendcheck.includes($(this).val()))){
                                        pendcheck.push($(this).val());    
                                    }
                           });

                           console.log(pendcheck);
                           $("#acceptmainto1").modal("hide");


                            $.ajax({
                                url: '/acceptstudents',
                                type: 'POST',
                                data:{
                                       "schedule":"{{$schedule->id}}",
                                       "student":pendcheck,
                                       
                                      
                                     },
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success:function(req){
                                    location.reload();
                                    //$('#pendingla').modal('show');
                                    console.log(req);
                                    
                                },error:function(){ 
                                    location.reload();
                                }
                             });



                      });
                      $('#acceptcancel').on('click',function(){
                           $("#acceptmainto1").modal('hide');
                      });
                      $('#removecancel').on('click',function(){
                           $("#removemainto1").modal('hide');
                      });

                       $("#removemain").on('click',function(){

                          var pendcheck = [];
                           $("input:checkbox[id ^= 'checkpends']:checked").map(function(){
                                if(!(pendcheck.includes($(this).val()))){
                                        pendcheck.push($(this).val());    
                                    }
                           });

                           console.log(pendcheck);
                           $("#removemainto1").modal("hide");


                            $.ajax({
                                url: '/denystudents',
                                type: 'POST',
                                data:{
                                       "schedule":"{{$schedule->id}}",
                                       "student":pendcheck,
                                       
                                      
                                     },
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success:function(req){
                                    location.reload();
                                    //$('#pendingla').modal('show');
                                    console.log(req);
                                    
                                },error:function(){ 
                                    location.reload();
                                }
                             });



                      });
                      $("#acceptmain").on('click',function(){

                          var pendcheck = [];
                           $("input:checkbox[id ^= 'checkpends']:checked").map(function(){
                                if(!(pendcheck.includes($(this).val()))){
                                        pendcheck.push($(this).val());    
                                    }
                           });
                            $("#acceptmainto1").modal("hide");
                           console.log(pendcheck);

                      });
                      $("#removemainto").hide();
                      $("#acceptmainto").hide();
                       $("#checkpendall").on('change',function(){
                           
                           $("input:checkbox[ id ^= 'checkpend']").prop("checked", $(this).prop("checked"));
                           
                          });
                       $("input:checkbox[id ^= 'checkpendall']").on('change',function(){
                          if($(this).prop("checked") == true){
                             //check lhat ng button kung may naka check
                         $("#removemainto").show();
                           $("#acceptmainto").show();
                          }
                           else{
                            $("#removemain").hide();
                            $("#acceptmain").hide();
                          
                          }
                        }) ;
                      $("input:checkbox[id ^= 'checkpend']").on('change',function(){
                          if($(this).prop("checked") == true){
                             //check lhat ng button kung may naka check
                         $("#removemainto").show();
                           $("#acceptmainto").show();
                          }
                           else{
                            $("#removemainto").hide();
                            $("#acceptmainto").hide();
                          
                          }
                        }) ;
                    </script>
                 </div>
                 
               </div>
             </div>
           </div>
  @endif
</div>
<div class ="table table-responsive">
<table class="table table-bordered table-hover">
          <thead align="center">
          <tr>
            <th>Name</th>
            @foreach($attend_week as $week)
           <th class="table{{$week['date']}}"> <a href="#" data-toggle="modal" data-target="#{{$week['date']}}sched{{$schedule->id}}">{{$week['week']}}</a></th>
            @endforeach
          </tr>
          </thead>
          <tbody style="border:solid black 1px; height:10%; ">
          @foreach($data1 as $datas)
              <tr align="left" id ="maintable{{$datas['id']}}" value= "{{$datas['id']}}">   
                <td style="height:1em" ><font size="2">&nbsp{{$datas['name']}}</font></td>
            @foreach($data as $datass) 
                @if($datass['id'] == $datas['id'])
                  @foreach($datass['week'] as $week23 ) 
                   @if($week23['status'] == 'PRESENT')
                    <td align="center" id ="{{$datas['id']}}table{{$week23['date']}}" class="table{{$week23['date']}}" value="{{$week23['status']}}"><font size="4" ><b style="color:#4682B4;">P </b></font></td>
                    @elseif($week23['status'] == 'LATE')
                    <td align="center" id ="{{$datas['id']}}table{{$week23['date']}}"  class="table{{$week23['date']}}"><font size="4"><b style="color:#FF8C00;">L</b></font></td>
                    @elseif($week23['status'] == "ABSENT")
                     <td align="center" id = "{{$datas['id']}}table{{$week23['date']}}"class="table{{$week23['date']}}"><font size="4"><b style="color:red;">A</b></font></td>
                     @else
                     <td align="center" id = "{{$datas['id']}}table{{$week23['date']}}"class="table{{$week23['date']}}"><font size="4"><b style="color:red;"></b></font></td>
                    @endif

                  @endforeach
                @endif
            @endforeach
              </tr>
          @endforeach 
              
          </tbody>
          <tfoot>
          <tr>
             
          </tr>
          </tfoot>
</table>
</div>

@foreach($attend_week as $weks)

 <div class="modal fade" id="{{$weks['date']}}sched{{$schedule->id}}">
  <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="{{$weks['date']}}close{{$schedule->id}}">
         <span aria-hidden="true">×</span></button>
         <h4 class="modal-title"><a class="btn.btn-app" id="dateupdate{{$weks['week']}}"><i class="fa fa-edit"></i> Attendance Report -{{$weks['week']}}({{date('M. d, Y',strtotime($weks['date']))}}) 
          </a>
           @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
          <div class="col-md-12">
            <input type="date" id ="datepicker{{$weks['date']}}" class="form">
          <button type="button" id="datechanger{{$weks['date']}}" class="btn btn-primary">Change date</button>
           </div>
           @endif
          
        </h4>
         
        
      </div>

      <div class="modal-body">
        <div id="checkdiv{{$weks['date']}}"class=" col-md-12" >
          <input type="hidden" id="allcheckingweek{{$weks['date']}}" value="{{$weks['date']}}">
          <select name="statuschec" id = "allchecking{{$weks['date']}}" class="form-control">
              
              <option value="">No status</option>
              <option value="PRESENT">PRESENT</option>
              <option value="LATE">LATE</option>
              <option value="ABSENT">ABSENT</option>
          </select>
          <br>
           <button type="submit" id="removestudent{{$weks['date']}}"class="btn btn-danger pull-right">Remove Student(s)</button> 
           <div class="modal fade" id="removemodal{{$weks['date']}}">
            <div class="modal-dialog" style="width:280px;">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title"></h4>
                 </div>
                  <div class="modal-body">
                   Are you sure you want to Remove all the checked students ?
                 </div>
                 <div class="modal-footer">
                  <button type="submit" class="btn btn-primary pull-left" dismiss="modal">Cancel</button> 
                  <button type="submit" id="removestudentna{{$weks['date']}}"class="btn btn-danger pull-right">Remove Student(s)</button> 
                 </div>
               </div>
             </div>
           </div>
        
        </div>
        <br>
          <table class="table table-bordered">
            <thead>
                <tr>
                  @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
                  <th><input type="checkbox" id="checkall{{$weks['date']}}" name="bakit"></th>
                  @endif
                  <th>Name</th>
                  <th>Status</th>
                </tr>
           </thead>
            <tbody>
         
             @foreach($data1 as $datas)
              <tr align="left" id="modaltable{{$weks['date']}}{{$datas['id']}}" value ="{{$datas['id']}}"> 

                 @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
                 <input type ="hidden" id="modaltable1{{$weks['date']}}{{$datas['id']}}" value ="{{$datas['id']}}">
                <td class="text-center"><input type="checkbox" id="chec{{$weks['date']}}[]" name ="check{{$weks['date']}}[{{$weks['date']}}]" value ="{{$datas['id']}}"></td>
                @endif
                <td style="height:1em">&nbsp{{$datas['name']}}</td>
                @foreach($data as $datass) 
                  @if($datass['id'] == $datas['id'])
                    @foreach($datass['week'] as $week24)
                      @if($week24['date'] == $weks['date'])
                      @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
                     <td>
                      <input type="hidden" id ="student{{$datas['id']}}" value="{{$datas['id']}}" name="id{{$datas['id']}}">
                      <input type="hidden" id ="date{{$weks['date']}}{{$datas['id']}}" value="{{$weks['date']}}" name="date{{$datas['id']}}">
                     {{Form::select('status',[''=>'No status','PRESENT' => 'PRESENT','LATE' => 'LATE','ABSENT' => 'ABSENT',],$week24['status'],['id'=>'status'.$weks['date'].$datas['id'],'class' => 'form-control'])}}
                     </td >
                      @else
                      <td>{{$week24['status']}}</td>
                      @endif
                      
                      <script>
                        //allchekingweek{{$weks['date']}}
                        $("#removestudentna{{$weks['date']}}").on("click",function(){
                            $("#removemodal{{$weks['date']}}").modal("hide");
                            $("#{{$weks['date']}}sched{{$schedule->id}}").modal("hide");
                            chek = [];
                            $("input:checkbox[id ^= 'chec{{$weks['date']}}']:checked").map(function(){
                                //console.log($("#modaltable1{{$weks['date']}}{{$datas['id']}}").val() + " "+  $(this).val());
                            if($("#modaltable1{{$weks['date']}}{{$datas['id']}}").val() ==  $(this).val()){

                                
                                $("#modaltable{{$weks['date']}}{{$datas['id']}}").remove();
                                 $("#maintable{{$datas['id']}}").remove();
                            }
                                if(!(chek.includes($(this).val()))){
                                    chek.push($(this).val());    
                                }
                                
                            });

                              var schedremo = "{{$schedule->id}}";
                               $.ajax({
                                url: '/removestudentsubject',
                                type: 'POST',
                                data:{
                                       "schedule":schedremo,
                                       "student":chek,
                                       
                                      
                                     },
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success:function(req){
                                 
                                    console.log(req);
                                    
                                },error:function(){ 
                                    //alert("error occurred");
                                }
                             });




                            console.log(chek);

                        });
                        $("#removestudent{{$weks['date']}}").on("click",function(){

                            $("#removemodal{{$weks['date']}}").modal("show");
                        });

                        $("#datepicker{{$weks['date']}}").hide();
                        $("#datechanger{{$weks['date']}}").hide();
                        $("#datechanger{{$weks['date']}}").on('click',function(){
                          var scheduling = "{{$schedule->id}}";
                          var selectdate= $("#datepicker{{$weks['date']}}").val();

                          console.log(selectdate);
                              $.ajax({
                                url: '/updateweek',
                                type: 'POST',
                                data:{
                                       "schedule":scheduling,
                                       "date":selectdate,
                                     },
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success:function(req){
                                 
                                    console.log(req);
                                    location.reload();
                                },error:function(){ 
                                    alert("error occurred");
                                    location.reload();
                                }
                             });
                        });

                        
                        $("#dateupdate{{$weks['week']}}").on('click',function(){
                           $("#datepicker{{$weks['date']}}").show();
                           $("#datechanger{{$weks['date']}}").show();


                        });
                           
//$("#{{$weks['date']}}sched{{$schedule->id}}").on('click',function(){
                           // $("#chec{{$weks['date']}}").prop('checked', false);
                           // $("#checkall{{$weks['date']}}").prop('checked', false);

                 //});
                 $("#removestudent{{$weks['date']}}").hide();
                  $("#allchecking{{$weks['date']}}").hide(); //tago yung select option

                  $("input:checkbox[id ^= 'checkall{{$weks['date']}}']").on('change',function(){
                    //ito yung sa allcheck 
                    if($(this).prop("checked") == true){
                      
                       $("#allchecking{{$weks['date']}}").show();
                       $("#removestudent{{$weks['date']}}").show();
                    }
                    else{
                      
                      $("#allchecking{{$weks['date']}}").hide();
                      $("#removestudent{{$weks['date']}}").hide();
                    }
                  }) ;                
                  $("input:checkbox[id ^= 'chec{{$weks['date']}}[]']").on('change',function(){
                    if($(this).prop("checked") == true){
                       //check lhat ng button kung may naka check
                       $("#allchecking{{$weks['date']}}").show();
                       $("#removestudent{{$weks['date']}}").show();

                    }
                     else{
                      
                      $("allchecking{{$weks['date']}}").hide();
                      $("#removestudent{{$weks['date']}}").hide();
                    }
                  }) ;         
              
                            $("#{{$weks['date']}}close{{$schedule->id}}").on('click',function(){
                            $("#chec{{$weks['date']}}").prop('checked', false);
                            $("#checkall{{$weks['date']}}").prop('checked', false);
                          });
                          
                           var chec =[];

                    $("#allchecking{{$weks['date']}}").on('change',function(){
                      //dropdown kapag nag change
                            var statuscheck = $("#allchecking{{$weks['date']}}").val();
                            $("input:checkbox[id ^= 'chec{{$weks['date']}}[]']:checked").map(function(){

                                // console.log($(this).val() + $("#student{{$datas['id']}}").val());
                            if($("#student{{$datas['id']}}").val() ==  $(this).val() ){
                                $("#status{{$weks['date'].$datas['id']}}").val(statuscheck);

                                 if(statuscheck == "PRESENT"){
                                    
                                    $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4" ><b style="color:#4682B4;">P </b></font>')
                                      $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                                  }
                                  else if(statuscheck == "LATE"){
                                    
                                     $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"><b style="color:#FF8C00;">L</b></font>')
                                     $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                                  }
                                  else if(statuscheck == "ABSENT"){
                                    
                                     $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"><b style="color:red;">A</b></font>')
                                     $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                                  }
                                  else{
                                    $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"></font>')
                                     $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                                  }

                            }
                                if(!(chec.includes($(this).val()))){
                                    chec.push($(this).val());    
                                }
                                
                            });
                            
                           var weekdate = $("#allcheckingweek{{$weks['date']}}").val();
                            var scheds = "{{$schedule->id}}";
                            console.log(chec,statuscheck,weekdate +"consolelog");
                       
                          $.ajax({
                            url: '/updateatt',
                            type: 'POST',
                            data:{"schedule":scheds,
                                   "status":statuscheck,
                                   "date":weekdate,
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
                         $("#checkall{{$weks['date']}}").on('change',function(){
                           
                           $("input:checkbox[ id ^= 'chec{{$weks['date']}}']").prop("checked", $(this).prop("checked"));
                           
                          });

                        $("#status{{$weks['date'].$datas['id']}}").on('change', function() {
                        $('#id{{$datas["id"]}}').val();
                        $('#date{{$datas["id"]}}').val();

                        var ids = "{{$schedule->id}}";
                        var statuss =  $(this).val();
                        var dates = $("#allcheckingweek{{$weks['date']}}").val();
                        var studs = $('#student{{$datas["id"]}}').val();
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
                                
                                $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4" ><b style="color:#4682B4;">P </b></font>')
                                $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                              }
                              else if(req.status == "LATE"){
                                
                                 $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"><b style="color:#FF8C00;">L</b></font>')
                                 $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                              }
                              else if(req.status == "ABSENT"){
                                
                                 $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"><b style="color:red;">A</b></font>')
                                 $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");
                              }
                              else{
                                $("#{{$datas['id']}}table{{$week24['date']}}").html('<font size="4"></font>')
                                 $("#{{$datas['id']}}table{{$week24['date']}}").addClass("table{{$week24['date']}}");

                              }
                              
                              
                          },error:function(){ 
                              alert("error occurred");
                          }
                       });
                         
                        



                    });
                      </script>
                      @endif
                    @endforeach
                  @endif
               
                @endforeach
              </tr>
          @endforeach 
           
           </tbody>
          
          </table>
  
      
     </div>
      <div class="modal-footer"><label class="form-control text-center">{{date('M. d, Y',strtotime($weks['date']))}}</label>
        
          <input type="hidden" id="scheddel{{$weks['date']}}" value="{{$schedule->id}}" name="sched_ids">
          <input type="hidden" id="datedel{{$weks['date']}}" value="{{$weks['date']}}" name="datedel">
           @if((Auth::user()->roles == 2 && $schedule->professor_id == $profes->id)|| Auth::user()->roles == 1)
         <button type="submit" id="attendel{{$weks['date']}}"class="btn btn-danger pull-right">delete attendance</button> 
       @endif
    </div>


                      
    </div>
  </div>
</div>
       <script>
                $("#attendel{{$weks['date']}}").on('click',function(){
                  var schz = $("#scheddel{{$weks['date']}}").val();
                  var datedel = $("#datedel{{$weks['date']}}").val();
                  $("#{{$weks['date']}}sched{{$schedule->id}}").modal('hide');
                  $(".table{{$weks['date']}}").remove();
                  console.log("column has been delete" + schz + datedel);
                
                $.ajax({
                          url: '/deleteatt',
                          type: 'POST',
                          data:{"schedule":schz,
                                 "date":datedel,
                                 
                                
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

        






      </script>   





@endforeach