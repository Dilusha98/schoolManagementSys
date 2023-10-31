<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tdashboard extends Controller
{
    public function index()
    {

        $teacherID = session()->get('user')->id;
        $year = date("Y");
        $getGrade = DB::table('studentclass')
            ->select('grade')
            ->where('teacher', $teacherID)
            ->get();
        $grade = '0' . $getGrade[0]->grade;
        $semesters = [1, 2, 3];

        $marks = DB::table('marks')
            ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where($grade, 1)
            ->where('marks.grade', $getGrade[0]->grade)
            ->where('marks.semester', 1)
            ->where('marks.year', $year)
            ->groupBy('subject_manages.id', 'subject_manages.subject')
            ->get();

        // get range
        $averageBelow35 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks < 35')
            ->get();

        $average35to54 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 35 AND average_marks <= 54')
            ->get();

        $average55to64 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 55 AND average_marks <= 64')
            ->get();

        $average65to74 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 65 AND average_marks <= 74')
            ->get();

        $average75to89 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 75 AND average_marks <= 89')
            ->get();

        $averageAbove90 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 90')
            ->get();

        $below35 = count($averageBelow35);
        $Avg35t54 = count($average35to54);
        $Avg55t64 = count($average55to64);
        $Avg65t74 = count($average65to74);
        $Avg75t89 = count($average75to89);
        $Avg90plus = count($averageAbove90);

        $counts = [
            'Below 35' => $below35,
            '35 to 54' => $Avg35t54,
            '55 to 64' => $Avg55t64,
            '65 to 74' => $Avg65t74,
            '75 to 89' => $Avg75t89,
            'Above 90' => $Avg90plus,
        ];

        $semesterOneData = [];
        $semesterTwoData = [];
        $semesterThreeData = [];

        foreach ($semesters as $semester) {
            $SemesterMarks = DB::table('marks')
                ->select('subject_manages.subject as subjectName', 'marks.marks')
                ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
                ->join('student_management_models', 'marks.studentID', '=', 'student_management_models.id')
                ->where($grade, 1)
                ->where('marks.semester', $semester)
                ->where('marks.year', $year)
                ->where('student_management_models.id', 2)
                ->get();

            if ($semester === 1) {
                $semesterOneData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            } elseif ($semester === 2) {
                $semesterTwoData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            } elseif ($semester === 3) {
                $semesterThreeData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            }
        }

        $stList = DB::table('student_management_models as student')
            ->select('student.id', 'student.studentFullName')
            ->join('studentclass as class', 'class.id', '=', 'student.classID')
            ->where('class.teacher', $teacherID)
            ->where('class.grade', $getGrade[0]->grade)
            ->get();

        return view('Teacher.dashboard', compact('marks', 'counts', 'semesterOneData', 'semesterTwoData', 'semesterThreeData', 'stList'));
    }

    public function lineCart($studentID)
    {

        $teacherID = session()->get('user')->id;
        $year = date("Y");
        $getGrade = DB::table('studentclass')
            ->select('grade')
            ->where('teacher', $teacherID)
            ->get();
            
        $grade = '0' . $getGrade[0]->grade;
        $semesters = [1, 2, 3];

        $semesterOneData = [];
        $semesterTwoData = [];
        $semesterThreeData = [];

        foreach ($semesters as $semester) {
            $SemesterMarks = DB::table('marks')
                ->select('subject_manages.subject as subjectName', 'marks.marks')
                ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
                ->join('student_management_models', 'marks.studentID', '=', 'student_management_models.id')
                ->where($grade, 1)
                ->where('marks.semester', $semester)
                ->where('marks.year', $year)
                ->where('student_management_models.id',$studentID)
                ->get();

            if ($semester === 1) {
                $semesterOneData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            } elseif ($semester === 2) {
                $semesterTwoData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            } elseif ($semester === 3) {
                $semesterThreeData = $SemesterMarks->pluck('marks', 'subjectName')->toArray();
            }
        }

        return response()->json([
            'semesterOneData' => $semesterOneData,
            'semesterTwoData' => $semesterTwoData,
            'semesterThreeData' => $semesterThreeData,
        ]);
    }

    public function generateAvgBarChart($sem)
    {
        $teacherID = session()->get('user')->id;
        $year = date("Y");
        $getGrade = DB::table('studentclass')
            ->select('grade')
            ->where('teacher', $teacherID)
            ->get();
        $grade = '0' . $getGrade[0]->grade;

        $marks = DB::table('marks')
            ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where($grade, 1)
            ->where('marks.grade', $getGrade[0]->grade)
            ->where('marks.semester', $sem)
            ->where('marks.year', $year)
            ->groupBy('subject_manages.id', 'subject_manages.subject')
            ->get();

        return $marks;
    }

    public function generateAvgCountPieChart($sem)
    {
        $teacherID = session()->get('user')->id;
        $year = date("Y");
        $getGrade = DB::table('studentclass')
            ->select('grade')
            ->where('teacher', $teacherID)
            ->get();
        $gra = $getGrade[0]->grade;
        
        if($gra == 10 || $gra == 11 || $gra == 12)
        {
            $grade = $gra;
        }else {
            $grade = '0'.$gra;
        }

        $averageBelow35 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks < 35')
            ->get();

        $average35to54 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 35 AND average_marks <= 54')
            ->get();

        $average55to64 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 55 AND average_marks <= 64')
            ->get();

        $average65to74 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 65 AND average_marks <= 74')
            ->get();

        $average75to89 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 75 AND average_marks <= 89')
            ->get();

        $averageAbove90 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', $sem)
            ->where($grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 90')
            ->get();

        $below35 = count($averageBelow35);
        $Avg35t54 = count($average35to54);
        $Avg55t64 = count($average55to64);
        $Avg65t74 = count($average65to74);
        $Avg75t89 = count($average75to89);
        $Avg90plus = count($averageAbove90);

        $counts = [
            'Below 35' => $below35,
            '35 to 54' => $Avg35t54,
            '55 to 64' => $Avg55t64,
            '65 to 74' => $Avg65t74,
            '75 to 89' => $Avg75t89,
            'Above 90' => $Avg90plus,
        ];

        return $counts;
    }
}
