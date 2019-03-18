<div class="box">
  <div class="box-header">
   <h3 class="box-title">
    <button type="button" class="btn btn-block btn-success btn-lg" data-toggle="modal" data-target="#modalko">
    <i class="fa fa-fw fa-user-plus"></i>ADD NEW PROFESSOR</button>
  </h3>
</div>
<div id="modalko" class="modal fade"  style="display: none;">
 <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span></button>
       <h4 class="modal-title">
        <i class="fa fa-fw fa-user-plus"></i>
        ADD NEW PROFESSOR</h4>
    </div>
    <form role="form" action="/professor" method="POST"> 
    <div class="modal-body">
      {{csrf_field()}}
      
        <div class="form-group"><label>ID number</label>
          <input  type="text" class="form-control" name="ProfessorId" >
       </div>
       <div class="form-group"><label>Title</label>
        {{Form::select('title', ['Mr.' => 'Mr.',
                               'Ms.' => 'Ms.',
                               'Mrs.' => 'Mrs.',
                               'Engr.' => 'Engr.',
                               'Dr.' => 'Dr.',
                               ],null,['class' => 'form-control'])}}
      </div>
      <div class="form-group"><label>First name</label>
        <input  type="text" class="form-control" name="firstname"  >
      </div>
      <div class="form-group"><label>Last Name</label>
      <input  type="text" class="form-control" name="lastname">
      </div>
      <div class="form-group"><label>Middle Initial</label>
       <input  type="text" class="form-control" name="middlename" >
      </div>
      <div class="form-group"><label>Gender 
                           
                            <div class="radio" style="margin-left:30px;">
                              {{  Form::radio('Gender','Male')}} Male   
                            </div>
                             <div class="radio" style="margin-left:30px;">   
                              {{ Form::radio('Gender','Female')}} Female
                            </div>
                            </label>
     </div> 
    <div class="form-group"><label>Email</label>
      <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group"><label>Contact</label>
      <input  type="text" class="form-control" name="contact" >
    </div>                  
                          </div><!--  body end -->
  <div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</div>
                                </form>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

          </div>
          <!-- /.box-header -->
              
          <!-- /.box-body -->
    