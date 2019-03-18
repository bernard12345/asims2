<div class="modal fade" id="modal-default{{$Section->id}}">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
<h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i> SECTION DETAILS</a></h4>
     </div>
    <div class="modal-body">
        <form role="form" action="section/{{$Section->id}}" method="POST">  
          {{method_field('PATCH')}}
          {{ csrf_field() }}
       <div class="box-body">
          <div class="form-group"><label>Course ID</label>
           {!! Form::select('cid',$courses,$Section->course_id,['class'=>'form-control']) !!}
           </div> 
          <div class="form-group"><label>Section Name</label>
      <input  type="text" class="form-control{{ $errors->has('secname') ? ' is-invalid' : '' }}" name="secname" value="{{$Section->section_name}}">
        
       <div class="form-group has-error">
        <span class="help-block"><strong>{{ $errors->first('secname') }}</strong></span>
         </div>   
    
        </div>

        <div class="form-group"><label>Section Year</label>
        <input  type="text" class="form-control{{ $errors->has('secyear') ? ' is-invalid' : '' }}" name="secyear" value="{{$Section->section_year}}"">
        </div>                
     </div>                    
      <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
          Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
                                  </form>
      </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                      
                            <!-- /.modal-dialog -->

                    