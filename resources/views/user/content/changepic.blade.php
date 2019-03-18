  <div class="tab-pane" id="avatar">
      <form class="form-horizontal" action="user/{{Auth::user()->id}}"  method="POST" enctype="multipart/form-data">
       {{csrf_field()}}
       {{method_field('PUT')}}
       <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Avatar</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name="picture" id="inputName" placeholder="Name" >
         </div>
       </div>
       <div class="form-group">
         <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" class="btn btn-danger">Submit</button>
         </div>
        </div>
      </form>
 </div>
