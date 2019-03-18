@extends('layouts.masters')
 @section('content')
    <section class="content-header">
      <h1>
        Manage Schedules
        <small>advanced tables</small>
      </h1>
 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
      
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Schedule list</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>          
                  <th>Section</th>
                  <th>Schedule</th>
                </tr>
                </thead>
                <tbody> 
               @foreach($secs as $sec)
                  <tr> 
                  <td>{{$sec->section_name}}</td> 
                  <form action ="/schedules/{{$sec->id}}" method="GET">
                   <td> <a class="btn.btn-app">
                   <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-edit"> View</i></button></a>
                 </td>
                  </form>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Section</th>
                  <th>Schedule</th>
                </tr>
                </tfoot>
              </table>
            </div>
       
          </div>
      
        </div>
   
      </div>
   
    </section>
 
     
@stop