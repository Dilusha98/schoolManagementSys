<?php

namespace App\Http\Controllers;

use App\Models\subjectManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectManageController extends Controller
{
    public function index()
    {
        return view('admin.subjects');
    }

    public function SaveSubject(Request $request)
    {
        $data = $request->input('checkedValuesObject');
        $subject = $data['subject'];

        $check = DB::table('subject_manages')
        ->select('*')
        ->where('subject',$subject)
        ->get();

        if ($check->isEmpty()) {

            subjectManage::create([
                'subject'=>$data['subject'],
                'description'=>$data['description'],
                '01'=>$data['01'],
                '02'=>$data['02'],
                '03'=>$data['03'],
                '04'=>$data['04'],
                '05'=>$data['05'],
                '06'=>$data['06'],
                '07'=>$data['07'],
                '08'=>$data['08'],
                '09'=>$data['09'],
                '10'=>$data['10'],
                '11'=>$data['11'],
                '12'=>$data['12'],
                '13'=>$data['13'],
            ]);
            return response()->json(['success'=>'Subject Added']);

        } else {
            return response()->json(['error'=>'Subject exists']);
        }
    }

    public function ViewSubjects() 
    {
        $subjects = DB::table('subject_manages')
        ->select('*')
        ->get();

        return $subjects;
    }
    public function DeleteSubject($id) 
    {
        subjectManage::where('id',$id)
        ->delete();
        return response()->json(['success'=>'Subject Deleted']);
    }
}
