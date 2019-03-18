<?php use App\Section;?>
@extends('layouts.masters')
@section('content')
<section class="content">
@include('flash')
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">My Subjects</h3>
  </div>
<form action="/addsubtostud" method=POST >
  {{ csrf_field() }}
  <div class="box-body">
    <div class="col-md-12">
      <table id="secsub" class="table table-bordered">
        <thead>
          <tr>
            <th>Subjects</th>
            <th>Section</th>
            <th><center><button type="button" name="addRows" class="btn btn-primary btn-sm" id="addRows"><i class="glyphicon glyphicon-plus"></i></button></center></th>
          </tr>
        </thead>
        <tbody>
         
          <tr>      
          <td style="width:55%;">
            {{Form::select('subid[]',$subjects,null,['class'=>'form-control','placeholder'=>'Please select a Subject'])}}
          </td>

            <td style="width:45%;">{{Form::select("secid[]",$sections,null,["class"=>"form-control","placeholder"=>"Please select a Section "])}}
          </td>
          <td></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class = "col-md-8">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Subject</th>
            <th>Section</th>
            <th>Term</th>
            <th>Batch</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($student->subjects as $subject) 
                <tr> 
                  <td>{{$subject->subject_title}}</td>       
                  <td>

                    <?php $sec=Section::where('id',$subject->pivot->section_id)->first(); ?>
                    {{ $sec->section_name}}
                  </td>

                  <td> {{$subject->pivot->term}}</td>
                  <td> {{$subject->pivot->batch}}</td>
                  <td>{{$subject->pivot->status}}</td>
                </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
     

  </div>
              <!-- /.box-body -->

  <div class="box-footer">
                <button type="submit" class="btn btn-lg btn-primary pull-right">Save</button>
  </div>
</form>
</div>
</section>        
@include('partials.javajs')
<script>
  $(document).ready(function() {
    $(document).on('click', '#addRows', function() {
      var html = '';
      html += '<tr>';
      html += '<td style="width:55%;">{{Form::select("subid[]",$subjects,null,["class"=>"form-control","placeholder"=>"Please select a Subject "])}}';
      html +='<td style="width:45%;">{{Form::select("secid[]",$sections,null,["class"=>"form-control","placeholder"=>"Please select a Section "])}}';
      html += '<td><center><button type="button" name="removeRows" class="btn btn-danger btn-sm" id="removeRows"><i class="glyphicon glyphicon-minus"></i></button></center></td></tr>';
      $('#secsub').append(html);
    });

    $(document).on('click', '#removeRows', function() {
      $(this).closest('tr').remove();
    });
  });
</script>
@stop