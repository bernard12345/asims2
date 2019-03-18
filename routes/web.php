<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/addattendance','AttendanceController@addattendance');

//magaadd ng subject si student
Route::get('/yoso','ScheduleController@scheduleforsections');
Route::get('/mysubjects','SubjectController@mystudentsubjects');
Route::post('/addsubtostud','SubjectController@addsubtostud');
Route::post('/linkmyacc','UserController@linkmyid');
Route::get('/adminlte1', function () {
    return view('adminlte1');
});
// testing ng pusher pwede na burahin

 Route::get('/notifys', 'PusherController@sendNotification');
 Route::get('/welcome',function(){ return view('calendar1'); });
// Route::redirect('/','/login');

Route::get('/',function (){  return redirect('/login'); });
Route::get('/home',function (){ return redirect('/profile'); });
// Route::redirect('/home','/profile');



Auth::routes();				
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::group(['middleware' => ['auth']], function () {

        Route::get('calendar',function(){

    return view('calendar.calendar');

});     
        Route::post('/acceptsumstud','AttendanceController@acceptsumstud');
        Route::post('/denysumstud','AttendanceController@denysumstud');
        Route::post('/removesumstud','AttendanceController@removesumstud');
        Route::post('acceptstudents','AttendanceController@acceptstudents');
        Route::post('denystudents','AttendanceController@denystudents');
        Route::post('/removestudentsubject','SubjectController@removestudentsubject');
        Route::post('/updateweek','AttendanceController@updateweek');
        Route::post('/deleteatt','AttendanceController@deleteatt');
        Route::post('/updateatt','AttendanceController@updateatt'); 
        Route::post('/updatekona','AttendanceController@updatekona');

        //Route::get('/admin', function (){ return view('admin.admin'); });
        Route::post('/notifyproftosecs','NotifyController@proftosec');
        Route::post('/notifyproftostud','NotifyController@proftostuds');
        Route::get('/notifyproftosec','NotifyController@notifyprof');
        Route::get('/notifyall','NotifyController@notifyall');
        Route::post('/notifyall','NotifyController@notifythemall');
        //taas mga route ng notification di ako sure kung may kulang pa 
        Route::post('/exportstudents','StudentController@exportstudents');
        Route::get('/exportstudentss','StudentController@exportstudentss');
        Route::post('/importstudents', 'SectionController@importstudents');//import ng student sa section
        Route::post('/importsection','StudentController@importsection');
        Route::post('/importsubjects','SubjectController@importsubjects');
        Route::get('/exportsubjects','SubjectController@exportsubjects');
        Route::post('/assignsubject','SubjectController@assubsec');//pagg aassign ng subject sa section para maging mas mdali yung pageenrol sa subject nila
        Route::post('addstudentsubject','SubjectController@assubstu');// add ng subject ng student sa student blade 
        Route::post('/subjectdetach','SubjectController@subjectdetach');//detach ng subject sa may section blade
        Route::post('studentsubdetach','SubjectController@studentsubdetach');//detach ng subject sa may section blade
        Route::post('subjectstudentdetach','SubjectController@subjectstudetach');

        // Route::get('marks',function(){
        //     auth()->user()->unreadNotifications->markAsRead();
        //     return redirect()->back(); //ito bagay na to di pa naapapagana !!!!!
        // }); //napagana na 
        Route::get('seenall','NotifyController@seenall');// dpat iread na laht ng notification niya kaso wla pa 
       // route resource mga route na built in na ni laravel para tatawagin mo na lng para maacces yung method
        Route::resources([
         'student' => 'StudentController',
         'professor' => 'ProfessorController',
         'section' => 'SectionController',
         'schedule' => 'ScheduleController',
         'subject' => 'SubjectController',
         'user' => 'UserController',
         'course' => 'CourseController',
         'notify'=> 'NotifyController',
         'term'=>'TermController'
        ]);
        
        // Route::get('/professorschedule','ProfessorController@profsched');
        Route::get('/studentattendance','StudentController@studentattendance');
        Route::get('/studentsection','SectionController@sectionstud');
         //profile ng nag login
        Route::get('/profile','UserController@userprofile');
        //hanapin
        //Route::get('profile/{id}', 'UserController@profile');//single profile 
        Route::get('/studentview/{id}','StudentController@studentview');//isang view ng student makikita yung subject niya at schedule 
        Route::post('/follow','UserController@follow');
        Route::post('/unfollow','UserController@unfollow');
        Route::post('/studsubattend','AttendanceController@studsubattend');
        Route::post('/removestudents','SectionController@removestudents');//remove ng students lagay to sa prof
        Route::post('/transferstudents','SectionController@transfertudents');//remove ng students lagay to sa proffer
        Route::get('/schedules/{id}','ScheduleController@schedulesec');
        Route::get('/scheduleforsection/{id}','ScheduleController@scheduleforsection');
        Route::post('profnames','ScheduleController@profnames');
        Route::post('subnames','ScheduleController@subnames');
        Route::post('/scheduling','ScheduleController@scheduling');//update ng schedule 
        Route::post('/schedelete','ScheduleController@schedelete');
        Route::get('studentwarning','AttendanceController@studentwarning');
        Route::get('weeklyreports','AttendanceController@weeklyreports');
        Route::get('statistics','AttendanceController@statistics');

        

});


//testing pa lng ng schedules
Route::post('/calendarko','ScheduleController@calendarko');
Route::get('/calendarmo','ScheduleController@calendarmo');

Route::get('/rfid','RfidController@rfid');
//rfid register user
Route::post('/rfid/register','RfidController@register');
//rfid all delete
Route::post('/rfid/delete','RfidController@deleteall');
//manual delete
Route::post('/rfid/{id}','RfidController@deleterfid');

//timeout cronjob
Route::get('/timeout','ScheduleController@timeout');
//absent cronjob ayuisn
Route::get('/absent','AttendanceController@absent');
//report Absent


//download any attendance report
Route::get('/download/report','AttendanceController@reportattendance');
// search sa date 
Route::get('/search','AttendanceController@search');
//search ng attendance kada schedule
//Route::post('/attendance/{id}','AttendanceController@attendance');

//download today attendance
Route::get('/download/report/today','AttendanceController@reporttoday');
//attendance for today isa isang sched
Route::get('/attendance/{id}','AttendanceController@todayattend');
Route::post('/summary','AttendanceController@todayattends');
//student attendance
Route::post('/attendance/student/{id}','AttendanceController@studentattend');
//student attendance report per schedule
Route::get('/download/student/report','AttendanceController@studentreport');

//statistics attendance
Route::post('/attendance/statistics/{id}','AttendanceController@stats');

//send email sa mga followers
Route::get('/followers/','AttendanceController@email');

//testing ng email design
Route::get('/email',function(){ return view('emails.emailfollowers'); });

//testing chart
Route::get('/chart','AttendanceController@chart');
Route::get('/charts','AttendanceController@charts');

//
Route::get('/polls','PollController@index');

// pag may time  hanapin tong mga method na to tignan kung saan pinag gagamit 

Route::get('/insertattend','StudentController@insertattend'); //wala lang hindi importante
Route::get('/myattendance/{id}','AttendanceController@myattendance')->name('myattendance');
Route::get('/scheduleattendances','AttendanceController@scheduleattendances');

Route::get('/mysection','AttendanceController@mysection');
Route::get('/schedulesection','ScheduleController@schedulesection');
Route::get('/studentsecs','SectionController@studentsecs');

Route::get('/studentenrolled','StudentController@studentenrolled');
Route::get('/viewsubject','SubjectController@subject');
//mga buburahin routes
Route::get('/testing','Controller@testing');
Route::get('/test','Controller@subject');
Route::get('/scheds','Controller@scheds');
Route::get('/boom','Controller@boom');
 