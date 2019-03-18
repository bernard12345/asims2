@extends('layouts.masters')
@section('content')
 <section class="content-header">
      <h1>
        Manage Professor
        <small>Data</small>
      </h1>
    </section>
    <section class="content">
      @include('flash')
      <div class="row">
        <div class="col-xs-12">
        @include('professor.profcrud.profadd')     
        
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Professor list</h3>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID number</th>
                  <th>Name</th>
                  <th>Gender</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>      
               @foreach($Profs as $prof)
                  <tr> 
                  <td>{{$prof->professor_id}}</td> 
                  <td>{{ $prof->professor_title }} {{ $prof->professor_firstname }} {{ $prof->professor_middlename }}. {{ $prof->professor_lastname }} 
                  </td>      
                  <td>{{$prof->professor_gender}}</td>
                   <td> <a class="btn.btn-app">
                   <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$prof->id}}"><i class="fa fa-edit"> View</i></button></a></td>
              @include('professor.profcrud.profedit')
          <!-- sa baba ito yung modal ng delete -->
                  <td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$prof->id}}">
                  <i class="fa fa-trash"> Delete</i></button></a></td>         
              @include('professor.profcrud.profdelete')
           <!-- sa taas ito yung modal ng delete -->
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID number</th>
                  <th>Name</th>
                  <th>Gender</th>
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
 

