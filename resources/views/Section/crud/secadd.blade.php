<div class="box">
  <div class="box-header">
    <div class="col-md-3">
      <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modalko">
      <i class="fa fa-fw fa-user-plus"></i>ADD NEW SECTION</button>
    </div>
    <div class="col-md-3">
      <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal1">
      <i class="fa fa-fw fa-user-plus"></i>ASSIGN SUBJECTS </button>
    </div>
    <div class="col-md-3">
      <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal2">
      <i class="fa fa-fw fa-user-plus"></i>ASSIGN STUDENTS </button>
    </div>
    <div class="col-md-3">
          <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#trans">
          <i class="fa fa-fw fa-user-plus"></i>Transfer / Remove</button>
    </div>  
  </div>
</div>

<div id="trans" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
        Transfer or Remove</h4>
    </div> 
    <form action="/transferstudents" method="POST">
       {{ csrf_field() }}
        <div class="modal-body">  
            <div class="form-group">
            <label>Section from :</label>
           {{Form::select('sectionids',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
           </div>
          <div class="form-group">
            <label>Section to:</label>
           {{Form::select('sectionids1',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
          </div>
        </div>
      <div class="modal-footer"> 
        <button type="submit" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#trans">
        <i class="fa fa-fw fa-user-plus"></i> Tranfer Students
        </button>
      </div>
      </form>
     
      <form action="/removestudents" method="POST">
        {{ csrf_field() }}
      <div class="modal-body"> 
        
        <div class="form-group">
          <label>Section to Remove:</label>
         {{Form::select('sectionremid',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
        </div>
      </div>
        <div class="modal-footer"> 
          <button type="submit" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#trans">
          <i class="fa fa-fw fa-user-plus"></i> Remove Students from this section
          </button>
        </div>
     </form>   
  </div>
 </div>
</div>
<!-- taas nito yung pag tratransfer ng student sa section nila at pag reremove ng student sa section -->

<!-- assign ng student kada section -->
<div id="modal2" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
        ASSIGN STUDENTS TO A SECTION</h4>
    </div> 
        <div class="modal-body">  
        <form role="form" action="/importstudents" method="POST" enctype="multipart/form-data"> 
        {{ csrf_field() }}
        <div class="form-group">
          <label>Section</label>
         {{Form::select('secids',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
        </div>

     
    <div class="form-group">
      <input type="file" name="import_file" class="form-control"/>
   </div> 
        <div class="modal-footer">
        <a class="btn.btn-app">
        <button type="submit" class="btn btn-primary">Import File</button></a>
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
   </div>
  </div>
</div>
<!--  assign ng mga subject sa bawat section -->
<div id="modal1" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
        ASSIGN SUBJECT TO A SECTION</h4>
    </div> 
        <div class="modal-body">  
        <form role="form" action="/assignsubject" method="POST"> 
        {{ csrf_field() }}
        <div class="form-group">
          <label>Section</label>
         {{Form::select('secids',$sections,null,['class'=>'form-control','placeholder'=>'Please select a Section'])}}
        </div>

       <table id="secsub" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Subject</th>

            <th><center><button type="button" name="addRows" class="btn btn-primary btn-sm" id="addRows"><i class="glyphicon glyphicon-plus"></i></button></center></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td style="width:75%;">

            {{Form::select('subid[]',$subjects,null,['class'=>'form-control','id'=>'select 2','placeholder'=>'Please select a Subject'])}}
          </td>
          <td></td>
          </tr>
        </tbody>
      </table>
        <div class="modal-footer">
        <a class="btn.btn-app">
        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
   </div>
  </div>
</div>
<!-- taas nito yung pag aasign ng ng student sa section -->
<!-- add ng section -->
<div id="modalko" class="modal fade"  style="display: none;">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title"><i class="fa fa-fw fa-user-plus"></i>
        ADD NEW SECTION</h4></div>    
      <div class="modal-body">   
        <form role="form" action="/section" method="POST"> 
        {{ csrf_field() }}
        <div class="box-body">
         <div class="form-group"><label>Course</label>
         {{Form::select('cid',$courses,null,['class'=>'form-control','placeholder'=>'Please select a Course'])}}
        </div> 
        <div class="form-group"><label>Section Name</label>
         <input  type="text" class="form-control{{ $errors->has('secname') ? ' is-invalid' : '' }}" name="secname" value="{{ old('secname')}}" >
        </div>
        <div class="form-group"><label>Section Year</label>
        <input  type="text" class="form-control{{ $errors->has('secyear') ? ' is-invalid' : '' }}" name="secyear" value="{{ old('secyear') }}">
        </div>
        </div>
        <div class="modal-footer">
        <a class="btn.btn-app">
        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        </div>
        </form>
       </div>
      </div>
    </div>
  </div>
  <!-- taas nito yung pag add ng section -->






