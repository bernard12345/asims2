@extends('layouts.masters')

 @section('content')
 


  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Section list</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Section ID</th>
                  <th>Course</th>
                  <th>Section Name</th>
                  <th>Section Year</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                
               @foreach($Sections as $Section)
                  
                 <tr> 
                 
                  <td>{{$Section->section_name}}</td>
                  
                      <td></td>

        
                        
                  <td></td>         
                   
                           

                </tr>

 

                @endforeach
                </tbody>
                <tfoot>
                <tr>
               
                  <th>Section Name</th>
                
                  
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
 

@stop