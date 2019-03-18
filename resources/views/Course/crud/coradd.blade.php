<h3 class="box-title">
<button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modal-default001"><i class="fa fa-fw fa-graduation-cap"></i>
   ADD NEW COURSE 
 </button>
 </h3>


<div class="modal fade" id="modal-default001" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span></button>
  <h4 class="modal-title"><i class="fa fa-fw fa-graduation-cap"></i>
  ADD NEW COURSE</h4>
      </div>
      <div class="modal-body">  
        <form role="form" action="/course" method="POST"> 
        {{ csrf_field() }}
          <div class="box-body">
              <div class="form-group"><label>Course</label>
              <input  type="text" class="form-control{{ $errors->has('course') ? ' is-invalid' : '' }}" name="course" value="{{ old('course') }}">     
              </div>
              <div class="form-group"><label>Course Code</label>
              <input  type="text" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="{{ old('code') }}">
              </div>
              <div class="form-group"><label>Course Type</label>
              {{Form::select('type', ['LEP' => 'LEP','ETP' => 'ETP',],
              null,['class' => 'form-control'])}}
              </div>  
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-default btn-lg pull-left" data-dismiss="modal">Close</button>
              <a class="btn.btn-app"><button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"> Save</i></button></a>
            </div>
                                  
                </form>  
                                  </div> 
                                </div>
                              </div>
                             </div>        
        
