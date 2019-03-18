<div class="modal fade" id="modal-default{{$Subject->id}}">
  <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><a class="btn.btn-app"><i class="fa fa-edit"></i> SUBJECT DETAILS</a></h4></div>
      <div class="modal-body">
      <form role="form" action="subject/{{$Subject->id}}" method="POST">  
        {{ method_field('PATCH') }}
        {{ csrf_field()}}  
        <div class="box-body">
          <div class="form-group"><label>Subject ID</label>
           <input  type="text" class="form-control{{ $errors->has('sid') ? ' is-invalid' : '' }}" name="sid" value="{{$Subject->id}}" readonly>
           </div>
           <div class="form-group"><label>Subject</label>
           <input  type="text" class="form-control{{ $errors->has('stitle') ? ' is-invalid' : '' }}" name="stitle" value="{{$Subject->subject_title}}">
            </div>
            <div class="form-group"><label>Subject Code</label>
             <input  type="text" class="form-control{{ $errors->has('scode') ? ' is-invalid' : '' }}" name="scode" value="{{$Subject->subject_code}}">
            </div>
            <div class="form-group">
                                              <label>Subject Type</label>
                                             {{Form::select('stype', [
                                               'Lecture' => 'Lecture',
                                               'Laboratory' => 'Laboratory',
                                               ],
                                               $Subject->subject_type,['class' => 'form-control']
                                              )}}
                                            </div>
                                            <div class="form-group">
                                            <label>Subject Units</label>
                                                <input  type="text" class="form-control{{ $errors->has('sunits') ? ' is-invalid' : '' }}" name="sunits" value="{{$Subject->subject_units}}">
                                            </div>                    
                                          </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                  </form>
                                </div>
                         
                              </div>
                          </div>
                   