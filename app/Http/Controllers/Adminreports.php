<?php

namespace App\Http\Controllers;

use App\Models\subjectManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Adminreports extends Controller
{
    public function index()
    {
        $subjectReport = $this->getSubjectReport();
        $studentAvgReport = $this->getStudentAvgReport(date("Y"),5,50,75);

        $subjects = SubjectManage::select('subject', 'id')->get();

        return view('admin.report',compact('subjectReport','studentAvgReport','subjects'));
    }

    public function getSubjectReport()
    {
        $currentYear = date("Y");
        $previousYear = $currentYear - 1;
    
        $data = DB::table('subject_manages')
            ->join('marks as current_year_marks', function ($join) use ($currentYear) {
                $join->on('subject_manages.id', '=', 'current_year_marks.subjectID')
                    ->where('current_year_marks.year', $currentYear);
            })
            ->join('marks as previous_year_marks', function ($join) use ($previousYear) {
                $join->on('subject_manages.id', '=', 'previous_year_marks.subjectID')
                    ->where('previous_year_marks.year', $previousYear);
            })
            ->select(
                'subject_manages.subject',
                DB::raw('AVG(current_year_marks.marks) as current_year_average_marks'),
                DB::raw('AVG(previous_year_marks.marks) as previous_year_average_marks')
            )
            ->groupBy('subject_manages.subject')
            ->get();
    
        return $data;
    }

    public function getStudentAvgReport($currentYear,$subjectID,$from,$to)
    {
        $students = DB::table('student_management_models')
            ->join('marks', 'student_management_models.id', '=', 'marks.studentID')
            ->join('studentclass', 'student_management_models.classID', '=', 'studentclass.id')
            ->where('marks.subjectID', $subjectID) 
            ->where('marks.year', $currentYear)
            ->select(
                'student_management_models.studentFullName',
                DB::raw('MAX(studentclass.grade) as grade'),
                DB::raw('MAX(studentclass.class) as class'),
                DB::raw('MAX(studentclass.stream) as stream'),
                DB::raw('MAX(studentclass.medium) as medium'),
                DB::raw('AVG(marks.marks) as average_marks')
            )
            ->groupBy('student_management_models.studentFullName')
            ->havingRaw('AVG(marks.marks) >= '.$from)
            ->havingRaw('AVG(marks.marks) <= '.$to)
            ->get();
    
        return $students;
    }

    public function getstudentWiseAjax(Request $request)
    {
        $year = $request->input('year');
        $subjects = $request->input('subjects');
        $from = $request->input('from');
        $to = $request->input('to');

        if ($year == null) {
            $year = date("Y");
        }
        if ($subjects == null) {
            $subjects = 5;
        }
        if ($from == null && $to == null) {
            $from = 50;
            $to = 75;
        }
        if ($from == null) {
            $from = 50;
        }
        if ($to == null) {
            $to = 100;
        }

        $studentAvgReport = $this->getStudentAvgReport($year,$subjects,$from,$to);

        return $studentAvgReport;

    }
    
    


    
    
    
}
