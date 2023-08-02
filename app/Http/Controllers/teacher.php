<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class teacher extends Controller
{

    public function Students($id){
        $studentLists = DB::table('studentclass')
        ->select('*')
        ->join('student_management_models','student_management_models.classID','=','studentclass.id')
        ->where('teacher',$id)
        ->get();
        return view('Teacher.studentsList',compact('studentLists'));
    }
}
