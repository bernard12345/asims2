@extends('layouts.masters')
@section('content')
<section class="content">

  <div class="col-md-12">
    @include('flash')
    <div class="box">
         <div class="box-header with-border">
          
            <h3 class="box-title">Send Notification to Everyone</h3>
         </div>
        <form action="notifyall" method="POST">
         <div class="box-body">
          {{ csrf_field() }}
          <div class="form-group"><label class="col-sm-3 control-label">
              Message to Everyone:</label>
                 <div class="col-md-12">
                  <textarea class="form-control" name="message"></textarea>
                 </div>
          </div>
          </div>
          <div class="box-footer">
             <button type="submit" class="btn btn-primary">Send</button>
         </div>
          </form>
        </div>
  </div>  
</div>

</section>
        
@stop

