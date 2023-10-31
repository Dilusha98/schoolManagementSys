<?php

use App\Http\Controllers\AdashBoard;
use App\Http\Controllers\classesManagementController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\marksController;
use App\Http\Controllers\report;
use App\Http\Controllers\StudentManagementModelController;
use App\Http\Controllers\SubjectManageController;
use App\Http\Controllers\Tdashboard;
use App\Http\Controllers\teacher;
use App\Http\Controllers\UserManagmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

// login
Route::get('/checkUnAndPw',[loginController::class,'index']);

// admin Dashboard
Route::get('/admin',[AdashBoard::class,'index']);
Route::get('/getAvgBarChartAdminSide/{sem}/{grade}',[AdashBoard::class,'generateAvgBarChart']);
Route::get('/viewlinechanrt/{grade}',[AdashBoard::class,'Viewlinechanrt']);
Route::get('/getAvgCountPieChartAdminSide/{grade}/{semester}',[AdashBoard::class,'getAvgCountPieChartAdminSide']);




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
//assign to a class
Route::post('/StudentAssignToClass/{stID}/{classsID}',[StudentManagementModelController::class,'StudentAssignToClasses']);
//select classes list
Route::get('/getClassesList',[StudentManagementModelController::class,'GetClassesList']);
//get current Class
Route::get('/getCurrentClass/{stID}',[StudentManagementModelController::class,'GetCurrentClass']);



//Mange Classes
Route::get('/ClassesManagement',[classesManagementController::class,'index'])->name('ClassesManagement');
Route::post('/saveClasses',[classesManagementController::class,'saveClass']);
Route::get('/viewClassList',[classesManagementController::class,'viewClass']);
Route::delete('/deleteClass/{id}',[classesManagementController::class,'deleteClass']);
Route::delete('/viewClassListTeacher',[classesManagementController::class,'viewClassListTeacher']);
Route::get('/getTeachersList',[classesManagementController::class,'GetTeachersList']);
Route::put('/assignTeacher/{classID}',[classesManagementController::class,'AssignTeacher']);
Route::get('/getCurrentTeacher/{id}',[classesManagementController::class,'GetCurrentTeacher']);
Route::get('/assignedOrNot/{selected}',[classesManagementController::class,'AssignedOrNot']);
Route::put('/removeClassTeacher/{classID}',[classesManagementController::class,'RemoveClassTeacher']);

//manage subjects
Route::get('/subject',[SubjectManageController::class,'index']);
Route::post('/saveSubject',[SubjectManageController::class,'SaveSubject']);
Route::get('/viewSubjects',[SubjectManageController::class,'ViewSubjects']);
Route::delete('/deleteSubject/{id}',[SubjectManageController::class,'DeleteSubject']);



// Teacher Dashboard
Route::get('/teacher',[Tdashboard::class,'index']);
Route::get('/studentsList/{id}',[teacher::class,'Students']);
Route::get('/studentDetails/{id}',[teacher::class,'StudentDetails']);
Route::get('/marks/{id}',[marksController::class,'index']);
Route::post('/savesemOneMarks',[marksController::class,'savesemOneMarks']);
Route::get('/getSemOneMarksToEdit',[marksController::class,'GetSemOneMarksEdit']);
Route::get('/reports-teacher/{id}',[report::class,'index']);
Route::get('/generateReport/{sem}/{id}',[report::class,'generateReport']);
Route::get('/getAvgBarChart/{sem}',[Tdashboard::class,'generateAvgBarChart']);
Route::get('/getAvgCountPieChart/{sem}',[Tdashboard::class,'generateAvgCountPieChart']);
Route::get('/getstudentAllMarks/{id}',[Tdashboard::class,'lineCart']);