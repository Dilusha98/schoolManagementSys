<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdashBoard extends Controller
{
    public function index()
    {
        $grade = '8';
        $year = date("Y");
        $previousYear = $year-1;

        $marks = DB::table('marks')
        ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
        ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
        ->where('0'.$grade, 1)
        ->where('marks.grade', $grade)
        ->where('marks.semester', 1)
        ->where('marks.year', $year)
        ->groupBy('subject_manages.id', 'subject_manages.subject')
        ->get();

        $previousYearMarks = DB::table('marks')
        ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
        ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
        ->where('0'.$grade, 1)
        ->where('marks.grade', $grade)
        ->where('marks.semester', 1)
        ->where('marks.year', $previousYear)
        ->groupBy('subject_manages.id', 'subject_manages.subject')
        ->get();


        // Pie chart
        $averageBelow35 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks < 35')
            ->get();

        $average35to54 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 35 AND average_marks <= 54')
            ->get();

        $average55to64 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 55 AND average_marks <= 64')
            ->get();

        $average65to74 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 65 AND average_marks <= 74')
            ->get();

        $average75to89 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
            ->where('year', $year)
            ->groupBy('studentID')
            ->havingRaw('average_marks >= 75 AND average_marks <= 89')
            ->get();

        $averageAbove90 = DB::table('marks')
            ->select('studentID', DB::raw('ROUND(AVG(marks)) as average_marks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where('semester', 1)
            ->where('0'.$grade, 1)
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

        $totalTeachers = DB::table('user_managments')->count();
        $totalStudents = DB::table('student_management_models')->count();

        return view('admin.dashboard',compact('marks','previousYearMarks', 'counts','totalTeachers','totalStudents'));
    }

    public function generateAvgBarChart($sem,$grade)
    {
        $year = date("Y");
        $Grade = '0' . $grade;

        $marks = DB::table('marks')
            ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
            ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
            ->where($Grade, 1)
            ->where('marks.grade', $grade)
            ->where('marks.semester', $sem)
            ->where('marks.year', $year)
            ->groupBy('subject_manages.id', 'subject_manages.subject')
            ->get();

        return $marks;
    }

    public function Viewlinechanrt($grade)
    {

        $year = date("Y");
        $previousYear = $year-1;

        $marks = DB::table('marks')
        ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
        ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
        ->where('0'.$grade, 1)
        ->where('marks.grade', $grade)
        ->where('marks.semester', 1)
        ->where('marks.year', $year)
        ->groupBy('subject_manages.id', 'subject_manages.subject')
        ->get();

        $previousYearMarks = DB::table('marks')
        ->select('subject_manages.id as subjectID', 'subject_manages.subject as subjectName', DB::raw('AVG(marks.marks) as AverageMarks'))
        ->join('subject_manages', 'marks.subjectID', '=', 'subject_manages.id')
        ->where('0'.$grade, 1)
        ->where('marks.grade', $grade)
        ->where('marks.semester', 1)
        ->where('marks.year', $previousYear)
        ->groupBy('subject_manages.id', 'subject_manages.subject')
        ->get();

        return response()->json([
            'currentYearData' => $marks,
            'previousYearData' => $previousYearMarks,  
        ]);
    }

    public function getAvgCountPieChartAdminSide($gra,$sem)
    {
        $year = date("Y");

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
