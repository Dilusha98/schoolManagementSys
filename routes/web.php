<?php

use App\Http\Controllers\classesManagementController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\StudentManagementModelController;
use App\Http\Controllers\UserManagmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

// login
Route::get('/checkUnAndPw',[loginController::class,'index']);


// admin Dashboard
Route::get('/admin', function () {
    return view('admin.dashboard');
});


// User Managment
Route::get('/userManagment',[UserManagmentController::class,'index']);
Route::post('/saveUser',[UserManagmentController::class,'saveUser']);
Route::get('/viewUserList',[UserManagmentController::class,'ViewUserList'])->name('viewUserList');
Route::delete('/deleteUser/{id}',[UserManagmentController::class,'DeleteUser'])->name('deleteUser');
Route::get('/viewUserListToEdit/{id}',[UserManagmentController::class,'ViewUserListToEdit'])->name('viewUserListToEdit');
Route::put('/updateUserDetails/{id}',[UserManagmentController::class,'UpdateUserDetails'])->name('updateUserDetails');


//Students Management
Route::get('/manageStudents',[StudentManagementModelController::class,'index']);
// register students
Route::post('/registerStudents',[StudentManagementModelController::class,'RegisterStudents']);
// view Students List
Route::get('/viewStudentsList',[StudentManagementModelController::class,'ViewStudentsList']);
// delete student
Route::delete('/deleteStudents/{id}',[StudentManagementModelController::class,'DeleteStudents']);
//get To Edit Student
Route::get('/getToEditStudent/{id}',[StudentManagementModelController::class,'GetToEditStudent']);
// Save Edited student Details
Route::put('/SaveEditedstudentDetails/{id}',[StudentManagementModelController::class,'SaveEditedstudentDetails']);


//Mange Classes
Route::get('/ClassesManagement',[classesManagementController::class,'index'])->name('ClassesManagement');
Route::post('/saveClasses',[classesManagementController::class,'saveClass']);
Route::get('/viewClassList',[classesManagementController::class,'viewClass']);
Route::delete('/deleteClass/{id}',[classesManagementController::class,'deleteClass']);





// Teacher Dashboard

Route::get('/teacher', function () {
    return view('Teacher.dashboard');
});