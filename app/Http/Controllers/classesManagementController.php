<?php

namespace App\Http\Controllers;

use App\Http\Requests\classValidateRequest;
use App\Models\classManagement;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class classesManagementController extends Controller
{
    public function index(){
        return view('admin.classesMangement');
    }

    public function saveClass(Request $request){
        // $input = $request->validated();

        $requestData = $request->selectedValues;

        foreach ($requestData as $data) {
            classManagement::create([
                'grade' => $data['grade'],
                'stream' => $data['stream'],
                'class' => $data['class'],
                'medium' => $data['medium'],
            ]);
        }
        return response()->json(['success' => 'User Added Successfully']);
    }

    public function viewClass(){
        $classList = DB::table('studentclass')->select('*')->get();

        $classlist=[];

        foreach ($classList as $classes) {


            if ($classes->stream == '0') {
                $stream = 'Not an AL class';
            }else {
                $stream = $classes->stream;
            }

            $classlist[] =[
                'id' => $classes->id,
                'grade' => $classes -> grade,
                'class' => $classes->class,
                'medium' => $classes->medium,
                'stream' => $stream,
            ];
        }
        return response()->json(['classList' => $classlist]);
    
    }

    public function deleteClass($id){

        classManagement::where(['id'=>$id,])->delete();

        return response()->json(['success' => 'Class deleted']);

    }

    public function viewClasssListToEdit($id){
        $viewDetailsToEdit = DB::table('studentclass')->select('*')->where('id',$id)->get();

        return response()->json(['classListToEdit' => $viewDetailsToEdit]);
    }

    public function GetTeachersList()
    {
        $teacherList = DB::table('user_managments')
        ->where('role',2)
        ->get();

        return response()->json(['teacherList'=> $teacherList]);
    }

    public function AssignTeacher(Request $request,$classID)
    {
        $teacher = $request->input('teacher');

        classManagement::where([
            'id'=>$classID,
        ])->update([
            'teacher'=>$teacher,
        ]);
        return response()->json(['success' => 'Teacher Added']);
    }

    public function getCurrentTeacher($id)
    {
        $currentTeacher = DB::table('user_managments')
        ->select('*')
        ->join('studentclass','studentclass.teacher', '=' , 'user_managments.id')
        ->where('studentclass.id',$id)
        ->get();

        if ($currentTeacher) {
            return response()->json(['currentTeacher'=> $currentTeacher]);
        } else {
            return response()->json(['status'=> 'A teacher has not been assigned !']);
        }   
    }

    public function AssignedOrNot($selected)
    {
        $selectedT = DB::table('studentclass')
        ->select('*')
        ->where('teacher',$selected)
        ->get();

        return $selectedT;       
    }

    public function RemoveClassTeacher($classID)
    {
        classManagement::where([
            ['id',$classID],
        ])->update([
            'teacher'=>0,
        ]);
        return response()->json(['success'=>'Teacher Removed!']);
    }
}
