 <div class="modal modal-danger fade" id="modaldanger{{$prof->id}}" style="display: none;">
   <div class="modal-dialog" style="margin-top:300px;">
     <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">×</span></button>
             <h4 class="modal-title">DELETE !!!</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete  <b>{{ $prof->professor_title }} {{ $prof->professor_firstname }} {{ $prof->professor_middlename }}. {{ $prof->professor_lastname }}</b> ?</p>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
           <form role="form" action="professor/{{$prof->professor_id}}" method="POST"> 
           {{ method_field('delete') }}
           {{csrf_field()}}
           
           <button type="submit" class="btn btn-outline">Delete</button>
           </form>
        </div>
    </div>
                        
   </div>
</div>
<script>
  </script>