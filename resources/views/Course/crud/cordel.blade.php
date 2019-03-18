 <td><a class="btn.btn-app"><button type="button" class=" btn btn-block btn btn-danger" data-toggle="modal" data-target="#anger{{$Course->id}}">
 <i class="fa fa-trash"> Delete</i></button></a></td>
   
<div class="modal modal-danger fade" id="anger{{$Course->id}}" style="display: none;">
  <div class="modal-dialog" style="margin-top:150px;">
    <div class="modal-content">
      <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
 <span aria-hidden="true">×</span></button><h4 class="modal-title">
 DELETE !!!</h4>
      </div>
      <div class="modal-body">
      <p>Are you sure you want to delete Course <b> {{ $Course->course_code }}</b> ?</p>
      </div>
<div class="modal-footer">
  <button type="button" class="btn btn-outline btn-lg pull-left" data-dismiss="modal">Close</button>
  <form role="form" action="course/{{$Course->id}}" method="POST"> 

    {{ method_field('DELETE')}}
    {{ csrf_field() }}
   
  <button type="submit" class="btn btn-outline btn-lg">Delete</button>
</form>
</div>
</div>
</div>
</div>