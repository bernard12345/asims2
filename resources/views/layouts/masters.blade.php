<!DOCTYPE html>
<html> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ASIMS| Dashboard</title>
  <meta content="width= device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="_token" content="{{csrf_token()}}" />
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
<link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="/bower_components/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

  <!-- Ionicons -->
 
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


</head>
<body class="hold-transition skin-blue ">
<div class="wrapper">
@include('sidebar.adminbar')

     <div class="content-wrapper">
      @yield('content')   
      </div>
 
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://adminlte.io">ASIMS</a>.</strong> All rights
    reserved.
  </footer>
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
<script src="/bower_components/moment/moment.js"></script>
<script src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>


<script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>





<script type="text/javascript">
    $(function () {
      $('#example0').DataTable()
    $('#example1').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable()
    $('#example5').DataTable()
    $('#example6').DataTable()
@if(Request::is('profile'))
  @if(Auth::user()->roles = 2 || Auth::user()->roles = 3)
     @if($student)
        <?php $s = 7; ?>
        <?php $eres = array('1st','2nd','3rd')?>
          @foreach($arrstu as $arrts)
            @foreach($eres as $ere)
             @foreach($student->subjects as $sd)
                $('#example{{$s}}').DataTable()
                <?php $s++; ?>
             @endforeach
            @endforeach
          @endforeach
      @elseif($professor)
         <?php $s = 7; ?>
         <?php $eres = array('1st','2nd','3rd')?>
          @foreach($arrstu as $arrts)
            @foreach($eres as $ere)
              @foreach($professor->schedules as $sd)
              $('#example{{$s}}').DataTable()
              <?php $s++; ?>
              @endforeach
            @endforeach
          @endforeach
    @endif

@endif 

@endif


@if(Request::is('section'))
 @if($Sections)
 <?php $s = 7; ?>
 @foreach($Sections as $Section)
  $('#example{{$s}}').DataTable()
 <?php $s++; ?>
 @endforeach
 @endif
@endif


@if(Request::is('studentview*'))
@if($student)
    <?php $s = 7; ?>
    <?php $eres = array('1st','2nd','3rd')?>
      @foreach($arrstu as $arrts)
        @foreach($eres as $ere)
         @foreach($student->subjects as $sd)
            $('#example{{$s}}').DataTable()
            <?php $s++; ?>
         @endforeach
        @endforeach
      @endforeach
@endif
@endif
@if(Request::is('attendancesearch*'))
<?php $s = 7 ;?>
@foreach($data as $datas => $key)
  $('#example{{$key}}').DataTable()
  <?php $s++; ?>
 @endforeach
@endif
    
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

<!-- page script -->
</body>
</html>
