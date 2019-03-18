<td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#modaldanger{{$Student->id}}">
<i class="fa fa-trash"> Delete</i></button></a></td>        
<div class="modal modal-danger fade" id="modaldanger{{$Student->id}}" style="display: none;">
  <div class="modal-dialog" style="margin-top:20%;">
    <div class="modal-content">
      <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">DELETE !!!</h4>
      </div>
      <div class="modal-body">
       <p>Are you sure you want to delete ? <b>Student {{ $Student->student_id }}</b> ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <form role="form" action="student/{{$Student->id}}" method="POST"> 
          {{csrf_field()}}
          {{ method_field('delete') }}
          <button type="submit" class="btn btn-outline">Delete</button>
       </form>
      </div>
    </div>
</div>
</div>