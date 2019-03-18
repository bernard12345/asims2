  <header class="main-header">
    <!-- Logo -->
    <a href="/profile" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">TUP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>ASIMS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
   <!--    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
 -->


 <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
















      

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!--<li class="dropdown messages-menu open">-->
          <li class="dropdown messages-menu" id="message">
            <a class="dropdown-toggle notification" id ="notifications" aria-expanded="true" href="#" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
            <span class="label label-success" id = "count" >@if(auth()->user()->unreadnotifications->count() > 0 )
                                                               {{auth()->user()->unreadnotifications->count() }}
                                                            @endif
            </span>
           
            </a>
            <ul class="dropdown-menu">
              <li class="header">
              @if(auth()->user()->unreadnotifications->count())
              You have new Notification(s)
              @else
              You have no New Notification
               @endif
               <small><a href="/marks"><p>Mark all as Read</p></a></small>
              </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id ="showNotifications">
                   
                 @foreach(auth()->user()->notifications as $notification)
                  <li><!-- start message -->
                    <a href="#">
                    <?php $photo = App\User::find($notification->data['sender_id']);?>
                      <div class="pull-left">
                        <img class="img-circle" alt="User Image" src="/images/{{$photo->avatar}}">
                      </div>
                      <h4>
                       {{ $notification->data['sender'] }}
                        
                        <small><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</small>
                      </h4>
                     @if($photo->roles == 1 || $photo->roles == 2)  
                      <p>{{ $notification->data['message'] }}</p>     
                     @else 
                      <p>I will be {{ $notification->data['status'] }} due to {{ $notification->data['reason'] }} problem   <br> {{ $notification->data['specify'] }}</p>  
                     @endif
                      
                    </a>
                 
                  </li>
                  @endforeach
                  <!-- end message --> 
                </ul>
              </li>
              <li class="footer"><a href="#">See All Notification</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
        @auth                  
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/images/{{ Auth::user()->avatar }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/images/{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                </p>
              </li>
              <!-- Menu Body -->
             <!--  <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                  

                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out </a>
                </div>    
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field()}}
                  </form>
              </li>
            </ul>
          </li>
              <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                     
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>


          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>



     <script src="https://js.pusher.com/4.2/pusher.min.js"></script>
      <script> 
                     
                      var pusher = new Pusher('033a636624d2992694ec',{
                        cluster: 'ap1',
                        encrypted: true
                      });
                      //Also remember to change channel and event name if your's are different.
                      var channel = pusher.subscribe('thesis');
                      channel.bind('notify-event', function(datas){
                        var html ='';
                        alert(datas.sender + datas.reason + datas.status +datas.path);//tangglin yung alert kapag okay na ang lhat 
                            html = '<li><a href="#"><div class="pull-left">'
                            html +='<img class="img-circle" alt="User Image" src="../images/'+datas.path+'">';
                            html += '</div><h4>'+ datas.sender+'</h4>';
                            html +='<p>I will be '+ datas.status +' due to '+datas.reason+' problem ';  
                            html += '<br>'+datas.specify+'</p>';
                            html +='</a></li>';
                        @if(Auth::check())
                        if({{Auth::user()->id}} == datas.id)
                        {
                          $("#showNotifications").prepend(html);
                           
                        }          
                        
                        @endif

                       
                          
                      });

                     // $("#notification").on("click" ,function(){
                     //      alert("check kung natatag ba");
                     //   //    // $.get('seenall',function(){});
                     // });
                    // Student to professor na notification
      </script>
      <script>
              var pusher = new Pusher('033a636624d2992694ec',{
                        cluster: 'ap1',
                        encrypted: true
                      });
                      //Also remember to change channel and event name if your's are different.
                      var channel = pusher.subscribe('thesis');
                      channel.bind('notify-section', function(datas){
                        var html ='';
                            html = '<li><a href="#"><div class="pull-left">'
                            html +='<img class="img-circle" alt="User Image" src="../images/'+datas.path+'">';
                            html += '</div><h4>'+ datas.sender+'</h4>';
                            html +='<p>'+ datas.message +'</p>';  
                            
                            html +='</a></li>';
                        @if(Auth::check())
                        if({{Auth::user()->id}} == datas.id)
                        {
                          $("#showNotifications").prepend(html);
                           
                        }          
                        
                        @endif

                       
                          
                      });
     
      </script>
      @include('partials.javajs')
<script>
  var count = $("#count").text();
  $("#message").on('click',function(){
     $('#count').hide();
       {{auth()->user()->unreadNotifications->markAsRead() }}
  });
 
</script>

  
  </header>
 