<div class="col-md-3">
<div class="box box-primary">
   <div class="box-header with-border">
       <h3 class="box-title">Detail</h3>
   </div>
   <div class="box-body">
     @if(Auth::user()->roles == 2)
      <strong><i class="fa fa-book margin-r-5"></i>Details</strong>
      <p class="text-muted">{{$professor['professor_details'] }}</p>
      <hr>
      <strong><i class="fa fa-phone margin-r-5"></i>Contact </strong> | 
      <p class="text-muted">{{ $professor['professor_contact'] }} </p>
      <hr>
      <strong><i class="glyphicon glyphicon-envelope"></i> Email</strong>
      <p class="text-muted">{{ Auth::user()->email }}</p>
      <hr>
     @endif 
     @if(Auth::user()->roles == 3)
      <strong><i class="fa fa-phone margin-r-5"></i>Contact </strong> 
       <p class="text-muted">{{ $student->student_contact }}</p>
       <hr>
       <strong><i class="glyphicon glyphicon-envelope"></i>Email</strong>
       <p class="text-muted">{{ Auth::user()->email }}</p>
       <hr>
     @endif 
        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>       
              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
      </div>        
</div>          
</div>
