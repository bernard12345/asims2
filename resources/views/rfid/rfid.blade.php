@extends('layouts.masters')
@section('content')


<section class="content-header">
@include('flash')
      <div class ="col-md-3"></div>

      <h1>
        RFID 
        <small>(Radio frequency identification)</small>
      </h1>
    </section>
    <section class="content">
      <div class="row " >
        <div class ="col-md-3"></div>
        <div class="col-md-6">
          <div class="nav-tabs-custom">
              <ul class="nav nav-tabs"> 
                <li class="active"><a href="#register" data-toggle="tab">Register</a></li>
                <li><a href="#delete" data-toggle="tab">Delete</a></li>
          
              </ul>

              <div class="tab-content"> 


               

                <div class ="active tab-pane" id="register">
                 @include('rfid.content.register')

                </div> 

                <div class="tab-pane" id="delete">

                 @include('rfid.content.delete')

                </div>     
            </div>
          </div>
         
      </div>
    </section>





@stop