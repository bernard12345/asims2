@extends('layouts.masters')
 @section('content')
<section class="content">
  <div class="col-md-4">
    @include('flash')
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs"> 
      <li class="active">
        <a href="#tosection" data-toggle="tab">Current Term</a>
     </li>
      <li>
        <a href="#tostudent" data-toggle="tab">Update term</a>
     </li>
     
    </ul>

<div class="tab-content"> 
    <div class ="active tab-pane" id="tosection">
    <div class="box">
       <div class="box-header">
        <h3 class="box-title">Term</h3>
       </div>
  
    <div class="box-body">
               
    <div class="form-group">
    <label>Current term:</label>
    <div>
      <h3> <label>{{$terms->term_name}}</label></h3>
    </div>
    
     <label>Current Year:</label>
    <div>
      <h3><label>{{$terms->batch}}</label></h3> 
    </div>
        <label>status term:</label>
    <div>
       <h3><label>{{$terms->status}}</label></h3>
     </div>


             
</div>
 
   
  </div>
     
        </div><!--  ito na yung end send to section  -->

   </div> 
   <div class="tab-pane" id="tostudent">
     <div class="box">
         <div class="box-header with-border">
         
            <h3 class="box-title">Start a new Term</h3>
         </div>
<div class="box-body">
    <form role="form" action="term/1" method="POST"> 
        {{ csrf_field() }}
         {{ method_field('PATCH')}}
         <div class="form-group">
                  
        <div>
        <div class="form-group">
            <label>Term</label>
         {{Form::select('name',['First term' => 'First term','Second term' => 'Second term',
         'Third term' => 'Third term',],$terms->term_name,['class' => 'form-control'])}}
        </div> 
        <div class="form-group">
            <label>Year</label>
            <input type="text" class="form-control" name="batch" value="{{$terms->batch}}">
        </div>
        <div class="form-group">
            <label>status</label>
         {{Form::select('status',['Started' => 'Started','Not started' => 'Not started',
          ],$terms->term_name,['class' => 'form-control'])}}
        </div> 
    </div>
             </div>
             <button type="submit" class="btn btn-primary">Save</button> 
    </form>
        
</div>
        
        </div>

  </div>
                        
            
    </div> <!-- TABCONTENT -->
  </div>  <!-- cUSTOM -->
</div>

</section>
        
@stop