

<?php

use Illuminate\Http\Request;
use App\Student;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::group(['middleware' => ['auth.api']], function(){

// });

Route::get('studentlists', 'UserController@studentlists');
Route::get('professorlists', 'UserController@index');



Route::get('studentprofile','ApiController@getStudentInfo');
Route::get('test','ApiController@register');
Route::get('studentsub','ApiController@studentsubject');

Route::get('studsection','ApiController@sectionlist');
Route::post('loginuser','ApiController@loginapi');
Route::post('notificationss','ApiController@viewnoti');
Route::post('profsched','ApiController@profsched');
Route::post('python','ApiController@python');
Route::post('pythons/{rfid}/{room}','ApiController@pythons');
Route::post('finger','ApiController@finger');
Route::post('keypad','ApiController@keypad');
Route::post('studsched','ApiController@studsched');
Route::get('sendtoprofessor','ApiController@sendtoprof');
Route::post('createnotification','ApiController@apinoti');
Route::post('getsecondaryid','ApiController@prof_secondID');
Route::get('getstudentlist','ApiController@studentlist');
Route::post('getstudentattend','ApiController@studentattend');
Route::post('gettodayattend','ApiController@todayattend');
Route::post('gethandledstudents','ApiController@handledstudents');
Route::post('updateattendance','ApiController@updateattendance');
Route::post('studschedsubject','ApiController@studschedsubject');
Route::post('getattend','ApiController@getattendance');

// Auth::Routes();

//  	<?php

// use Illuminate\Http\Request;
// use App\Student;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//  Route::post('/apinotify','ApiController@apinoti');
//  Route::post('/viewnoti','ApiController@viewnoti');
//  Route::get('tests','UserController@loginapi');
//  Route::post('profsched','ApiController@profsched');

// Route::get('tests',function(){
// 	$string = array('sdf'=>'sd','sdf'=>'sf');
// 	$string1 = json_encode($string);

// 		return redirect('/tests',$string1);
// });
