<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class report extends Controller
{
    public function index($id)
    {
        $studentLists = DB::table('studentclass')
        ->select('*')
        ->join('student_management_models','student_management_models.classID','=','studentclass.id')
        ->where('teacher',$id)
        ->get();

        return view('Teacher.reports',compact('studentLists'));
    }

    public function generateReport($sem,$id)
    {
        $year = date("Y");
        $marks = DB::table('marks')
        ->select('marks.*', 'subject_manages.subject as subjectName')
        ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
        ->where('marks.studentID', $id)
        ->where('marks.semester', $sem)
        ->where('marks.year', $year)
        ->get();

        $studentInfo = DB::table('marks')
            ->select('studentID', DB::raw('SUM(marks) as total_marks'), DB::raw('AVG(marks) as average_marks'))
            ->where('studentID', $id)
            ->where('semester', $sem)
            ->groupBy('studentID')
            ->first();

        if ($studentInfo) {
            $totalMarks = $studentInfo->total_marks;
            $averageMarks = $studentInfo->average_marks;
        } else {
            $totalMarks = 0;
            $averageMarks = 0;
        }

        $studentMarks = DB::table('marks')
            ->select('studentID', DB::raw('SUM(marks) as total_marks'))
            ->where('semester', $sem)
            ->groupBy('studentID')
            ->orderByDesc('total_marks')
            ->get();

        $rank = $studentMarks->pluck('studentID')->search($id) + 1;

        return response()->json([
            'marks' => $marks,
            'totalMarks' => $totalMarks,
            'averageMarks' => $averageMarks,
            'rank' => $rank,
        ]);
    }
}
