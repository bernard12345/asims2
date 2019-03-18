

<table id="example2" class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>ID number</th>
      <th>Name</th>
      <th>RFID</th>
      <th></th>
    </tr>
    </thead>
    <tbody>      
    @foreach($dprof as $prof)
    <tr> 
      <td>{{$prof->professor_id}}</td> 
      <td>{{$prof->professor_lastname}} {{$prof->professor_firstname}}</td>      
      <td>{{$prof->rfid_tag}}</td>
      <form role="form" action="rfid/{{$prof->professor_id}}" method="POST">
      {{csrf_field()}}
      <td><a class="btn.btn-app">
            <button type="submit" class="btn btn-block btn-danger" ><i class="fa fa-trash"> Remove</i></button>
          </a>
      </td>
      </form>
    </tr>

    @endforeach
     
    </tbody>
    <tfoot>
    <tr>
      <th>ID number</th>
      <th>Name</th>
      <th>RFID</th>
      <th></th>
    </tr>
    </tfoot>
  </table>

<form role="form" action="rfid/delete" method="POST"> 
  {{csrf_field()}}
  <div class="form-group">
          <h4>Remove all graduated student (optional)</h4>
          <button type="submit" class="btn btn-lg btn-danger">Remove</button>
  </div>
</form>