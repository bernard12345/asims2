 <div class="modal fade" id="modal-default01" style="display: none;">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><i class="fa fa-fw fa-book"></i>
          ADD NEW SUBJECT</h4>
          </div>
       <div class="modal-body">
           <form role="form" action="/subject" method="POST"> 
              {{ csrf_field() }}
           <div class="box-body">
             <div class="form-group"><label>Subject</label>
              <input  type="text" class="form-control{{ $errors->has('stitle') ? ' is-invalid' : '' }}" name="stitle" value="{{ old('stitle') }}">
               </div>
            <div class="form-group"><label>Subject Code</label>
            <input  type="text" class="form-control{{ $errors->has('scode') ? ' is-invalid' : '' }}" name="scode" value="{{ old('scode') }}">
             </div>
             <div class="form-group"><label>Subject Type</label>
             {{Form::select('stype', ['Lecture' => 'Lecture','Laboratory' => 'Laboratory',
               ],null,['class' => 'form-control'] )}}</div>
                <div class="form-group"><label>Subject Units</label>
                 <input  type="text" class="form-control{{ $errors->has('sunits') ? ' is-invalid' : '' }}" name="sunits" value="{{ old('sunits') }}">
                  </div>
        </div>                    
        <div class="modal-footer">
         <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button><a class="btn.btn-app"><button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
       </div>
      </form>
</div>
</div>
</div>
</div>