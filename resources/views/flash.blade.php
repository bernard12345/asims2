  @if($errors->any())
            
               <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Whoops!! Something got wrong !</h4>
                @foreach($errors->all() as $error)
                <li> {{$error}} </li>
                @endforeach
              </div>
            
           @endif
           
              @if(session('status'))
           
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>Sucessfully !</h4>
                {{ session('status') }}
              </div>
            
              @endif

              @if(session('erro'))  
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i>  Successfully! {{ session('erro') }}</h4>
              </div>

              @endif