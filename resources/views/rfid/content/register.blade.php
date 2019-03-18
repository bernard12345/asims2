
<h3>Register</h3>
<form role="form" action="rfid/register" method="POST"> 
    {{csrf_field()}}
    <div class="box-body">

      
    	<div class="form-group">
        	<label>ID Number</label>
        		{{Form::select('id',$id,null,['class'=>'form-control','placeholder'=>'Please select a ID Number'])}}
       	</div>
    
      	<div class="form-group">
        	<label>Availabe RFID</label>
        	{{Form::select('rfid',$rfid,null,['class'=>'form-control','placeholder'=>'Please select a RFID'])}}
      	</div>
      	<div class="form-group">
      		<button type="submit" class="btn btn-lg btn-primary">Register</button>
      	</div>
    </div>
       
</form>



