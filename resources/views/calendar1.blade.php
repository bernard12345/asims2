 @extends('layouts.masters')
@section('content')  
<style>

    #wrap {
        width: 1100px;
        margin: 0 auto;
    }
    #external-events {
        float: left;
        width: 250px;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
        text-align: left;
    }
    #external-events h4 {
        font-size: 16px;
        margin-top: 0;
        padding-top: 1em;
    }
    #external-events .fc-event {
        margin: 10px 0;
        cursor: pointer;
    }
    #external-events p {
        margin: 1.5em 0;
        font-size: 11px;
        color: #666;
    }
    #external-events p input {
        margin: 0;
        vertical-align: middle;
    }
    #calendar {
        float: right;
        width: 780px;
    }
    .orange {
        background-color: orange;
    }
    .red {
        background-color: red;
    }
    .purple {
        background-color: purple;
    }
</style>
<section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="box">
               <div id='external-events' style="margin-top: 73px; margin-left: 30px;">
            <h4>{{$section->section_name}}</h4>
        @foreach($section->subjects as $subject)
        <div class='external-event bg-light-blue' id="{{$subject->id}}">{{$subject->subject_title}} </div>
        @endforeach
        <div class="form-group"><label>Professor</label>
         <select name="prof" class="form-control" id="prof">
                    <option value="">Please Select a Professor</option>
                  @foreach($profs as $prof)
                    <option value="{{ $prof->id }}">{{ $prof->professor_title }} {{ $prof->professor_firstname }} {{ $prof->professor_middlename }}. {{ $prof->professor_lastname }} </option>
                  @endforeach
         </select>
     </div>
      <div class="form-group" ><label>Room</label>
                 <select name="room" class="form-control" id="room">
                    <option value="">Please Select a room</option>
                   <option value="Aquarium">Aquarium</option>
                   <option value="IT laboratory">IT laboratory</option>
                   <option value="Computer laboratory">Computer laboratory</option>
                 </select>
       
      </div> 
    </div>
    <div id='calendar'></div>
    <div style='clear:both'></div>
          </div>
      </div>
  </div>


  


<div id="loading" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
      PLEASE WAIT WHILE PROCESSING</h4>
    </div> 
        <div class="modal-body overlay">  
          
              <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
    

    </div>
  </div>
</div>

























</section>

 

@include('partials.javajs')

<script>
        $(document).ready(function () {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
      /* initialize the external events
    -----------------------------------------------------------------*/
       
      $('#external-events .bg-light-blue').each(function () {
        
        
      //  console.log($('#subject').val());
          // store data so the calendar knows to render an event upon drop
          $(this).data('event', {
              start:'',
              end:'',
              backgroundColor:'#337ab7',
              title: $.trim($(this).text()),
              professor:$('#prof').text(),
              room:$('#room').val(),
               // use the element's text as the event title
              stick: true, // maintain when user navigates (see docs on the renderEvent method)
              id: $(this).attr('id')
          });

          // make the event draggable using jQuery UI
          $(this).draggable({
              zIndex: 999,
              revert: true, // will cause the event to go back to its
              revertDuration: 0 //  original position after the drag
          });

      });


      /* initialize the calendar
    -----------------------------------------------------------------*/

      $('#calendar').fullCalendar({
          header: {
              left: 'none',
              center: 'title',
              right: 'none'
          },
          allDaySlot: false,
          slotEventOverlap: false,
          eventOverlap: function (stillEvent, movingEvent) {
              return stillEvent.allDay && movingEvent.allDay;
          },
          columnFormat:'dddd',
          titleFormat: 'dddd',
          hiddenDays:[0],
       
  events: function(start, end, timezone, callback) {
      $.ajax({
        url: '/scheduleforsection/{{$section->id}}',
        type:"GET",
        data: {
        
        },
        success:function(doc) {
         // var obj = jQuery.parseJSON(doc);
          var events = [];
          $.each(doc,function(index,value) {

                //alert(value['id']);
            events.push({
              id: value['id'],
              title:value['subject_id'],
              room:value['room_assignment'],
              professor:value['professor_id'],
              start:value['date']+'T'+value['schedule_start_24'],
              end:value['date']+'T'+value['schedule_end_24'],
              backgroundColor:'#337ab7'
              //all data
            });
            

          });
          callback(events);
        },
        error: function(e, x, y) {
          console.log(e);
          console.log(x);
          console.log(y);
        }
      });
     
    },
                     
            //kapag ginalaw yung event sa calendar
          eventDrop: function (event, delta, revertFunc) {
             
              console.log(event.id);
              var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration'));
              var end = event.end || event.start.clone().add(defaultDuration);
               console.log('start is'+ event.start.format('HH:mm:ss')+'  end is ' + end.format('dddd'));
                console.log('end is ' + end.format('HH:mm:ss'));


                $.ajax({  
                url: "/scheduling",
                type:'POST',
                data:{
                       "id":event.id,
                       "start":event.start.format('HH:mm:ss'),
                       "date":event.start.format('YYYY-MM-DD'),
                       "end":end.format('HH:mm:ss'),
                       "day":end.format('dddd'),
                     },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success:function(req){
                    console.log(req);
                   
                   // alert("successfully updated new schedule ");
                },error:function(){ 
                   // alert("error !!!!");
                }
            });



            
          },
          eventResize: function (event, delta, revertFunc) {
              console.log(event.id);
              console.log(event.start.format('HH:mm:ss')+"Start time: " + event.start.format('dddd') + "end time: " + event.end.format('HH:mm:ss'));
              $.ajax({
                url: "/scheduling",
                type: 'POST',
                data:{
                       "id":event.id,
                       "day":event.start.format('dddd'),
                       "date":event.start.format('YYYY-MM-DD'),
                       "start":event.start.format('HH:mm:ss'),
                       "end":event.end.format('HH:mm:ss'),
                     },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success:function(req){
                    console.log(req)
                    //alert("successfully updated new attendance ");
                },error:function(){ 
                    //alert("error !!!!");
                }
            });

          },
          timeFormat: 'H(:mm)',
          minTime:'7:00',
          maxTime:'22:00',
          editable: true,
          defaultView: 'agendaWeek',
          droppable: true, // this allows things to be dropped onto the calendar
          drop: function (date,event,data) {

              //Call when you drop any red/green/blue class to the week table.....first time runs only.....
              console.log("dropped");
              console.log(date.format());
              console.log(this.id);
              var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration'));
              var end = date.clone().add(defaultDuration); // on drop we only have date given to us
              console.log(' start is ' +date.format('dddd') + '  end is ' + end.format() + " date "+ $('#prof').val() + $('#room').val() +date.format('HH:mm:ss'));

              $('#loading').modal('show');
              $.ajax({
                url: "/schedule",
                type: 'POST',
                data:{
                       "day":date.format('dddd'),
                       "section":{{ $section->id }},
                       "subject":this.id,
                       "professor":$('#prof').val(),
                       "room":$('#room').val(),
                       "date":date.format('YYYY-MM-DD'),
                       "start":date.format('HH:mm:ss'),
                       "end":end.format('HH:mm:ss'),
                     },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success:function(req){
                    console.log(req)
                  event.id = req['schedule_id'];
                   event.professor = req['professor_id'];
                // $('#calendar').fullCalendar( 'rerenderEvents'); 
                 

            //  events.push({
             // event.id: req['schedule_id'];,
             // event.title:req['subject_id'],
              // event.room:req['room_assignment'],
             //   event.professor:req['professor_id'],
             //   event.start:req['date']+'T'+req['schedule_start_24'],
             //   event.end:req['date']+'T'+req['schedule_end_24'],
             //   backgroundColor:'#337ab7'
              //all data
           // });
            
                

                $('#loading').modal('hide');
                    location.reload();
                          
                            //callback(events);
                   // alert("successfully inserted new attendance ");
                },error:function(req){ 
                    console.log(req)
                     $('#loading').modal('hide');
                    // alert("Error occurred please check the professor and the room");
                     // location.reload();
                }

            });




          //di pa sure kung need ng reload yung page


              // is the "remove after drop" checkbox checked?
              /*if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }*/
          },
eventRender: function(event, element) 
{ console.log("event.professor")     
  console.log(event.professor)
        
      $.ajax({
                url: "/profnames",
                type: 'POST',
                data:{
                       "id":event.professor,
                     },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success:function(reqs){
                    console.log(reqs)
                  element.find('.fc-title').append("<br/>  " + reqs );
                },error:function(){ 
                    console.log("error")
                   // alert("error !!!!");
                }
            }); 
       
       // element.find('.fc-title').append("<br/>  " + event.professor );
       element.find('.fc-title').append("<br/>" + event.room );
       element.find(".fc-bg").css("pointer-events","none");
       element.append("<div style='position:absolute;bottom:0px;right:0px' ><button type='button' id='btnDeleteEvent' class='btn btn-block btn-primary btn-flat'>X</button></div>" );
       element.find("#btnDeleteEvent").click(function(){
        $('#loading').modal('show');
            $('#calendar').fullCalendar('removeEvents',event._id);


                $.ajax({
                url: "/schedelete",
                type: 'POST',
                data:{
                       "id":event.id,
                     },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success:function(req){
                    console.log(req)
                    $('#loading').modal('hide');
                   // alert("successfully delete schedule ");
                },error:function(req){ 
                  console.log(req)
                  $('#loading').modal('hide');
                    //alert("error !!!!");
                }
            });
       });
}
      });

$('#calendar').fullCalendar('gotoDate','2018-09-08');


  });
</script>



@endsection