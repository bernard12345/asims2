@include('partials.header')

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel --> 
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/images/{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
        @auth
          <p>{{ Auth::user()->name }}</p>
        @endAuth
          
        </div>
      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
       @if(Auth::user()->roles == 1)
        <li class="{{Request::is('admin*') ? 'active' : ''}}">
          <a href="#">
            <i class="fa fa-book"></i> 
            <span>Admin Dashboard</span>
          </a>
        </li> 
<li class="active treeview">
  <a href="#">
    <i class="fa fa-dashboard"></i> <span>Maintenance</span>
    <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
  </a>
 <ul class="treeview-menu">
    <li class="{{(Request::is('student*') or Request::is('professor*') or Request::is('rfid*') ) ? 'active' : ''}} treeview">
      <a href="#"><i class="fa fa-circle-o"></i> Users
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
      </a>
      <ul class="treeview-menu">
        
        <li class="{{Request::is('student*') ? 'active' : ''}}">
        <a href="{{url('/student')}}"><i class="fa fa-graduation-cap">
        </i>Students</a></li>
        <li class="{{Request::is('professor*') ? 'active' : ''}}">
        <a href="{{url('/professor')}}"><i class="fa fa-circle-o">
        </i>Professors</a></li>
        <li class="{{Request::is('rfid')? 'active' : ''}}">
        <a href="{{url('/rfid')}}"><i class="fa fa-circle-o"></i>Rfid</a></li>
      </ul>
    </li>   
            <li class="{{Request::is('section*')? 'active' : ''}}"><a href="/section"><i class="fa fa-group "></i>Sections</a></li>
            <li class="{{Request::is('subject*')? 'active' : ''}}"><a href="/subject"><i class="fa fa-circle-o"></i>Subjects</a></li>
            <li class="{{Request::is('schedule*')? 'active' : ''}}"><a href="/schedule"><i class="fa  fa-calendar"></i>Schedules</a></li>
            <li class="{{Request::is('course*')? 'active' : ''}}"><a href="/course"><i class="fa fa-circle-o"></i>Courses</a></li>
            <li class="{{Request::is('term*')? 'active' : ''}}"><a href="/term"><i class="fa fa-circle-o"></i>Term</a></li>
            <!-- <li class="{{Request::is('statistics')? 'active' : ''}}"><a href="{{url('/statistics')}}"><i class="fa fa-circle-o"></i>attendance statistics</a></li> -->
            <li class="{{Request::is('notifyall*')? 'active' : ''}}"><a href="/notifyall"><i class="fa fa-envelope"></i>Send Notification</a></li>
  </ul>
</li>

        
        @elseif(Auth::user()->roles == 3)

        <li class="{{Request::is('notify') ? 'active' : ''}}">
          <a href="/notify">
            <i class="fa fa-envelope"></i> 
            <span>Notification to Professor</span>
          </a>
        </li>

       <!--  <li class="{{Request::is('polls') ? 'active' : ''}}">
          <a href="/polls">
            <i class="fa fa-book"></i> 
            <span>Polls</span>
          </a>
        </li> -->
        <li class="{{Request::is('mysubjects') ? 'active' : ''}}">
          <a href="/mysubjects">
            <i class="fa fa-book"></i> 
            <span>My Subjects</span>
          </a>
        </li>
      

        @elseif(Auth::user()->roles == 2)
          <li class="{{Request::is('schedule') ? 'active' : ''}}">
          <a href="/schedule">
            <i class="fa fa-calendar"></i> 
            <span>Schedule</span>
          </a>
        </li> 
          <li class="{{Request::is('student*') ? 'active' : ''}}  ">
          <a href="/student">
            <i class="fa fa-graduation-cap"></i> 
            <span>Students</span>
          </a>
        </li>

        <li class="{{Request::is('subject*') ? 'active' : ''}}">
          <a href="/subject">
            <i class="fa fa-book"></i> 
            <span>Subjects</span>
          </a>
        </li>
        <li class="{{Request::is('section*') ? 'active' : ''}}">
          <a href="/section">
            <i class="fa fa-group"></i> 
            <span>Sections</span>
          </a>
        </li>
          <li class="{{Request::is('notifyproftosec*') ? 'active' : ''}}">
          <a href="/notifyproftosec">
            <i class="fa fa-envelope"></i> 
            <span>Send Notification</span>
          </a>
        </li>
          @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>