<td> <a class="btn.btn-app">
<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#mod{{$Course->id}}"><i class="fa fa-edit"> View</i></button></a></td>

<div class="modal fade" id="mod{{$Course->id}}">
  <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">×</span></button>
         <h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i> Course Details</a></h4>
      </div>
      <div class="modal-body">
      <form role="form" action="course/{{$Course->id}}" method="POST">  
      
       {{ method_field('PATCH')}}
       {{ csrf_field()}}
     
     <div class="box-body">
       <div class="form-group"><label>Course ID</label>
        <input  type="text" class="form-control" name="id" value="{{$Course->id}}" readonly>
      </div>
      <div class="form-group"><label>Course</label>
        <input  type="text" class="form-control" name="course" value="{{ $Course->course_name }}">
      </div>
      <div class="form-group"><label>Course code</label>
      <input  type="text" class="form-control" name="code" value="{{ $Course->course_code }}">
      </div>
      <div class="form-group"><label>Course Type</label>
       {{Form::select('type',['LEP'=>'LEP','ETP'=>'ETP',],
       $Course->course_type,['class' => 'form-control'])}}
      </div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-lg">Save changes</button>  
    </div>
    </form>                  
    </div>
  </div>
</div>
                   