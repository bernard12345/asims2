@extends('layouts.masters')

 @section('content')

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
                  <th>Student ID</th>
                  <th>Section ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Gender</th>
                  <th>Status</th>

                 
                  
                </tr>
                </thead>
                <tbody>
                
           
   @foreach($Students as $Student)

                  <tr> 
                  <td>{{$Student->student_id}}</td>      
                  <td>{{$Student->sections['section_name']}}</td>   
                  <td><a href ="profile/{{$Student->id}}">{{$Student->student_firstname}} {{$Student->student_middlename}}.{{$Student->student_lastname}}</a></td>
                  <td>{{$Student->student_contact}}</td>
                  <td>{{$Student->gender}}</td>
                  <td>{{$Student->status}}</td>

                



                </tr>

 

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                   <th>Student ID</th>
                  <th>Section ID</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Gender</th>
                  <th>Status</th>
                 
                  
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