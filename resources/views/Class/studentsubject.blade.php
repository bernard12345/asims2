@extends('layouts.masters')

 @section('content')
 


  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Subjects
        <small>Data</small>
      </h1>

    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        
           
          <!-- /.box -->


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Subject list</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Subject ID</th>
                  <th>Subject</th>
                  <th>Subject Code</th>
                  <th>Subject Type</th>
                  <th>Units</th>

                  <th></th>
                  
                </tr>
                </thead>
                <tbody>
                
               @foreach($Subjects as $Subject)

                  <tr> 
                  <td>{{$Subject->id}}</td> 
                  <td>{{$Subject->subject_title}}</td>
                  <td>{{$Subject->subject_code}}</td>
                  <td>{{$Subject->subject_type}}</td>
                  <td>{{$Subject->subject_units}}</td>

            <td><a class="btn.btn-app" href="/studentenrolled">
                   <button type="button" class="btn btn-block btn-primary"><i class="fa fa-edit"> View</i></button></a>

               
                 </td>
                   




                </tr>

 

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Subject ID</th>
                  <th>Subject</th>
                  <th>Subject Code</th>
                  <th>Subject Type</th>
                  <th>Units</th>
                  <th></th>
                 
                  
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
 

@stop