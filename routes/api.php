<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GradeSectionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserGradeSectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public
///////////////sanctum auth ///////////////
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login
Route::post('/user/login', [UserController::class, 'login']);

// logout
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user', [UserController::class, 'addUser']);
    Route::put('/user/{id}', [UserController::class, 'updateUser']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
    Route::post('/user/logout', [UserController::class, 'logout']);
});

///////////        USER            ///////
Route::get('/allUser', [UserController::class, 'getAllUsers']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);
// Route::post('/user',[UserController::class,'addUser']);
// Route::put('/user/{id}',[UserController::class,'updateUser']);
// Route::delete('/user/{id}',[UserController::class,'deleteUser']);
Route::get('/teacher', [UserController::class, 'getTeacher']);
Route::get('/student', [UserController::class, 'getStudents']);
Route::get('/users/{role}', [UserController::class, 'getUserCountByRole']);
Route::get('/userss/{firstName}', [UserController::class, 'getUserByName']);

/*******Grade ****/
Route::get('/grade/{id}', [GradeController::class, 'getGradeById']);
Route::get('/grade', [GradeController::class, 'getGrade']);
Route::post('/grade', [GradeController::class, 'addGrade']);
Route::delete('/grade/{id}', [GradeController::class, 'deleteGrade']);
Route::put('/grade/{id}', [GradeController::class, 'updateGrade']);


/**********Attendance */
Route::post('/attendance/{id}', [AttendanceController::class, 'createAttendance']);
Route::get('/attendance', [AttendanceController::class, 'getAll']);
Route::get('/attendance/student/{id}', [AttendanceController::class, 'getByStudent']);
Route::get('/attendance/gradeSection/{id}', [AttendanceController::class, 'getByGradeSectionId']);
Route::get('/attendance/status/{grade_section_id}', [AttendanceController::class, 'getAttendanceCountBystatus']);


/*********Course */
Route::post('/course', [CourseController::class, 'createCourse']);
Route::get('/course/getAll', [CourseController::class, 'getAllCourses']);
Route::get('/course/{id}', [CourseController::class, 'getCourse']);
Route::delete('deleteById/{id}', [CourseController::class, 'deleteById']);
Route::get('/user-grade-section', [CourseController::class, 'index']);


/*******Section ****/
Route::Get('/section', [SectionController::class, 'getSection']);
Route::Get('/section/{id}', [SectionController::class, 'getSingleSection']);
Route::Post('/addsection', [SectionController::class, 'addSection']);
Route::Patch('/updatesection/{id}', [SectionController::class, 'updateSection']);
Route::Delete('/section/{id}', [SectionController::class, 'deleteSection']);


/****Get students from grade section */
Route::Get('/allStudent/{gradeId}/{sectionId}',[SectionController::class,'studentList']);



/*******Attendance by grade id and section id */
Route::Get('/attendance/{gradeId}/{sectionId}',[AttendanceController::class,'getAttendeesByGradeidSectionid']);



/****New grade section with given section and grade */
Route::Post('/newGradesection/{gradeId}/{sectionId}',[GradeController::class,'newGradesection']);
