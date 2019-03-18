@extends('layouts.masters')
 @section('content')
    <section class="content-header">
      <h1>
        Manage Subjects
      </h1>
    </section>
  <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                
              <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal-default01"><i class="fa fa-fw fa-book"></i>
              ADD NEW SUBJECT </button></h3>
          
              <div class="col-md-3">
              <a  href="/exportsubjects">
              <button type="button" class="btn btn-block btn-success btn-lg"><i class="fa fa-fw fa-book"></i>
              Export Subjects </button></a>
              </div>
              <div class="col-md-3">
              
              <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#importsub"><i class="fa fa-fw fa-book"></i>
              Import Subjects </button>
              </div>
              <div class="modal fade" id="importsub" >
               <div class="modal-dialog" style="margin-top:100px;">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                   <h4 class="modal-title">IMPORT SUBJECTS</h4>
                  </div>
                  <div class="modal-body">
                    <form action="/importsubjects" method="POST" enctype="multipart/form-data">
                      {{ csrf_field()}}
                       <div class="form-group">
                       <div class="col-sm-10">
                       <input type="file" class="form-control" name="import_file"  placeholder="file import" >
                       </div>
                     </div>
                  </div>
                   <div class="modal-footer">
                   <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-block btn-success btn-lg" ><i class="fa fa-fw fa-save"></i>
              Import Subjects </button>
                 
                 </div>
               </form>
                </div>
                </div>
             </div>















              @include('Subject.crud.subadd')
            </div>
          </div>
          @include('flash')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Subject list</h3>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Subject</th>
                  <th>Subject Code</th>
                  <th>Subject Type</th>
                  <th>Units</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>  
               @foreach($Subjects as $Subject)
                  <tr> 
                  <td>{{$Subject->subject_title}}</td>
                  <td>{{$Subject->subject_code}}</td>
                  <td>{{$Subject->subject_type}}</td>
                  <td>{{$Subject->subject_units}}</td>
                  <td> <a class="btn.btn-app">
                   <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default{{$Subject->id}}"><i class="fa fa-edit"> View</i></button></a></td>
                    @include('subject.crud.subedit')
                  <td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$Subject->id}}">
                  <i class="fa fa-trash"> Delete</i></button></a></td>         
                   @include('subject.crud.subdel')                                            </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Subject</th>
                  <th>Subject Code</th>
                  <th>Subject Type</th>
                  <th>Units</th>
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