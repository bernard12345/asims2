@extends('layouts.masters')

 @section('content')
    <section class="content-header">
      <h1>
        Manage Sectionsssssssssss
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal-default01"><i class="fa fa-fw fa-inbox"></i>
              ADD NEW SECTION
              </button></h3>
             @include('section.crud.secadd')
            </div>
          </div>
   @include('flash')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Section list</h3>
            </div>
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
                  <td>{{$Section->id}}</td> 
                  <td>{{$Section->courses['course_name']}}</td>
                  <td>{{$Section->section_name}}</td>
                  <td>{{$Section->section_year}}</td>
                  <td> <a class="btn.btn-app">
                  <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$Section->id}}"><i class="fa fa-edit"> View</i></button></a></td>                  
                    @include('section.crud.secedit')     
                  <td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$Section->id}}">
                  <i class="fa fa-trash"> Delete</i></button></a></td>         
                             
                            @include('section.crud.secdel')
                          </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Section ID</th>
                  <th>Course</th>
                  <th>Section Name</th>
                  <th>Section Year</th>
                  <th></th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
            </div>       
          </div>     
        </div>
      </div>
     
    </section>
@stop