<?php

namespace App\Http\Controllers;

use App\Http\Requests\editStudentDetailsRequest;
use App\Http\Requests\studentRegisterRequest;
use App\Models\StudentManagementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentManagementModelController extends Controller
{
    public function index()
    {
        return view('admin.StudentsManagement');
    }

    public function RegisterStudents(studentRegisterRequest $request)
    {
        $input = $request->validated();

        // dd($input['guardianPostalCode']);

        StudentManagementModel::create([
            'studentFullName'=>$input['studentFullName'],
            'studentInitials'=>$input['studentInitials'],
            'studentBirthday'=>$input['studentBirthday'],
            'studentGender'=>$input['studentGender'],
            'studentNationality'=>$input['studentNationality'],
            'guardianType'=>$input['guardianType'],
            'guardianFullName'=>$input['guardianFullName'],
            'guardianInitials'=>$input['guardianInitials'],
            'guardianNIC'=>$input['guardianNIC'],
            'guardianBirthday'=>$input['guardianBirthday'],
            'guardianEmail'=>$input['guardianEmail'],
            'guardianAddress'=>$input['guardianAddress'],
            'guardianPostalCode'=>$input['guardianPostalCode'],
            'guardianOccupation'=>$input['guardianOccupation'],
        ]);
        return response()->json(['success' => 'Student Registered Successfully']);
    }

    public function ViewStudentsList()
    {
        $studentsList = DB::table('student_management_models')
        ->select('*')
        ->get();

        return response()->json(['studentsList' => $studentsList ]);
    }

    public function DeleteStudents($id)
    {
        StudentManagementModel::where([
            'id'=>$id,
        ])->delete();

        return response()->json([
            'success' => 'Student deleted Successfully!'
        ]);
    }

    public function GetToEditStudent($id) 
    {
        $studentToEdit = DB::table('student_management_models')
        ->select('*')
        ->where('id',$id)
        ->get();

        return response()->json(['student' => $studentToEdit ]);
    }

    public function SaveEditedstudentDetails(editStudentDetailsRequest $request,$id)
    {
        $input = $request->validated();

        StudentManagementModel::where([
            'id' => $id,
        ])->update([
            'studentFullName'=>$input['studentFullName'],
            'studentInitials'=>$input['studentInitials'],
            'studentBirthday'=>$input['studentBirthday'],
            'studentGender'=>$input['studentGender'],
            'studentNationality'=>$input['studentNationality'],
            'guardianType'=>$input['guardianType'],
            'guardianFullName'=>$input['guardianFullName'],
            'guardianInitials'=>$input['guardianInitials'],
            'guardianNIC'=>$input['guardianNIC'],
            'guardianBirthday'=>$input['guardianBirthday'],
            'guardianEmail'=>$input['guardianEmail'],
            'guardianAddress'=>$input['guardianAddress'],
            'guardianPostalCode'=>$input['guardianPostalCode'],
            'guardianOccupation'=>$input['guardianOccupation'],
        ]);
        return response()->json([
            'success' => 'Student Details Updated Successfully!'
        ]);
    }

    public function GetClassesList()
    {
        $classList = DB::table('studentclass')
        ->select('*')
        ->get();

        return response()->json(['classList'=> $classList]);
    }

    public function StudentAssignToClasses($stID,$classsID)
    {
        StudentManagementModel::where([
            ['id',$stID],
        ])->update([
            'classID'=>$classsID,
        ]);
        return response()->json(['success'=>'Successfully assigned!']);
    }

    public function GetCurrentClass($stID)
    {
        $curentClass = DB::table('student_management_models')
        ->select('*')
        ->join('studentclass','studentclass.id', '=' , 'student_management_models.classID')
        ->where('student_management_models.id',$stID)
        ->get();
        return response()->json(['CurrentClass'=>$curentClass]);
    }
}
