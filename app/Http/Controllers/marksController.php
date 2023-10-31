<?php

namespace App\Http\Controllers;

use App\Models\marks;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class marksController extends Controller
{
    public function index($id)
    {
        $studentLists = DB::table('studentclass')
        ->select('*')
        ->join('student_management_models','student_management_models.classID','=','studentclass.id')
        ->where('teacher',$id)
        ->get();

        foreach ($studentLists as $student) {
            $grade ='0'.$student->grade;
        }

        $subjects = DB::table('subject_manages')
        ->select('*')
        ->where($grade ,'=', '1')
        ->get();

        return view('Teacher.Marks',compact('studentLists','subjects'));
    }


    public function savesemOneMarks(Request $request)
    {
        $data = $request->input('data');
        $inputValues = $request->input('inputValues'); 

        // dd($inputValues);

        $isEmpty = marks::where([
            'subjectID'=>$data['subjectID'],
            'class'=>$data['thisClass'],
            'grade'=>$data['thisGrade'],
            'year'=>$data['currentYear'],
            'semester'=>$data['semester'],
        ])->count();

        if ($isEmpty == 0) {

            foreach ($inputValues as $studentId => $inputValue) {
                marks::create([
                    'studentID' => $studentId,
                    'subjectID' => $data['subjectID'],
                    'class' => $data['thisClass'],
                    'grade' => $data['thisGrade'],
                    'year' => $data['currentYear'],
                    'marks' => $inputValue,
                    'semester' => $data['semester'],
                ]);
            }
    
            return response()->json([
                'success' => 'saved!',
            ]);

        } else {

            foreach ($inputValues as $studentId => $inputValue) {
                marks::where([
                    'subjectID' => $data['subjectID'],
                    'class' => $data['thisClass'],
                    'grade' => $data['thisGrade'],
                    'year' => $data['currentYear'],
                    'semester' => $data['semester'],
                    'studentID' => $studentId,
                ])->update([
                    'marks' => $inputValue,
                ]);
            }
    
            return response()->json([
                'success' => 'Updated!',
            ]);
        }
        

    }

    public function GetSemOneMarksEdit(Request $request)
    {
        $data = $request->input('data');

        $stList = marks::select('studentID' , 'marks')
        ->where([
            'subjectID'=> $data['subjectID'],
            'class'=> $data['thisClass'],
            'grade'=> $data['thisGrade'],
            'year'=> $data['currentYear'], 
            'semester'=> $data['semester'],
        ])->get();
        return response()->json([
            'stList'=>$stList,
        ]);
    }
}
