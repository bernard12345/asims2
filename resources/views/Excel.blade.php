@extends('layouts.masters')
 
@section('content')
 
<section class="content">
        <a href="{{ URL::to('download-excel/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
        <a href="{{ URL::to('download-excel/xlsx') }}"><button class="btn btn-info">Download Excel xlsx</button></a>
        <a href="{{ URL::to('download-excel') }}"><button class="btn btn-warning">Download CSV</button></a>
 
   
        <form class="form-horizontal" action="/import"  method="POST" enctype="multipart/form-data">
                @csrf
              

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">File</label>

                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="data" id="data" placeholder="data" >
                    </div>
                  </div>
    
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Import File</button>
                    </div>
                  </div>
                </form>
  
   
</section>

 
@endsection