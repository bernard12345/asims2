<!DOCTYPE html>
<html> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student Monitoring| Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width= device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="/bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">





  
  <!-- Ionicons -->
 
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
 

























</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('sidebar.adminbar')

     <div class="content-wrapper">
      @yield('content')   
      </div>
 
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  @include('sidebar.controlbar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        
</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>


<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>





<script type="text/javascript">
    $(function (){
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    });
  });
</script>

<script>
        $(document).ready(function () {


        /* initialize the external events
        -----------------------------------------------------------------*/

        $('#external-events .fc-event').each(function () {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $(this).text(),stick: true,
                yolo: $(this).text(),
                professor:"bernard jeff Igcasenza",
                room:"Computer Lab",
                 // maintain when user navigates (see docs on the renderEvent method)
                id: $(this).text()
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
                left: 'today',
                center: 'title',
                right: 'agendaWeek'
            },
            slotduration:'00:15:00',
            allDaySlot: false,
            slotEventOverlap: true,
            eventOverlap: function (stillEvent, movingEvent) {
                return stillEvent.allDay && movingEvent.allDay;
            },
            columnFormat:'dddd',
            titleFormat: 'dddd',     
            hiddenDays: [0] ,
            minTime: "07:00:00",
            maxTime: "22:00:00",
            eventDrop: function (event, delta, revertFunc) {
                 
                //inner column movement drop so get start and call the ajax function......
                console.log(event.start.format());
                console.log(event.id);
                var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration'));
                var end = event.end || event.start.clone().add(defaultDuration);
                console.log('end is ' + end.format());

                alert(event.title + " was dropped on " + event.start.format());

            },
            eventResize: function (event, delta, revertFunc) {
                console.log(event.id);
                console.log("Start time: " + event.start.format() + "end time: " + event.end.format());

            },
            timeFormat: 'H(:mm)',
            editable: true,
            defaultView: 'agendaWeek',
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function (date,event) {
                //Call when you drop any red/green/blue class to the week table.....first time runs only.....
                var titles = $(this).data('event').title
                var yolo = $(this).data('event').yolo
                console.log("dropped " + titles);
                console.log(date.format('l'));
                console.log(this.id);
                var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration'));
                var end = date.clone().add(defaultDuration); // on drop we only have date given to us
                console.log('end is ' + end.format());
         alert(titles +" "+ yolo + " was dropped on " + date.format());

                // is the "remove after drop" checkbox checked?
                /*if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }*/
            },
            eventRender: function (event, element) 
            {
     element.find('.fc-title').append("<br/>" + event.professor +"<br/>" + event.room); 
            }

        });
        

    });
</script>



















<!-- page script -->
 





 
 

</body>
</html>
