<?php

namespace App\Http\Controllers;

use App\Http\Requests\classValidateRequest;
use App\Models\classManagement;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class classesManagementController extends Controller
{
    public function index(){
        return view('admin.classesMangement');
    }

    public function saveClass(classValidateRequest $request){
        $input = $request->validated();

        classManagement::create([
            'grade' => $input['grade'],
            'stream' => $input['stream'],
            'class' => $input['class'],
            'medium' => $input['medium'],
        ]);
        return response()->json(['success' => 'User Added Successfully']);
    }

    public function viewClass(){
        $classList = DB::table('studentclass')->select('*')->get();



        $classlist=[];

        foreach ($classList as $classes) {
            if ($classes->stream == 0) {
                $stream = 'Not an AL student';
            } elseif ($classes->stream == 1) {
                $stream = 'Science';
            } elseif ($classes->stream == 2) {
                $stream = 'Commerce';
            } elseif ($classes->stream == 3) {
                $stream = 'Art';
            } elseif ($classes->stream == 4) {
                $stream = 'Tech';
            } else {
                $stream = 'Unknown';
            }


            if ($classes->medium == 0) {
                $medium = 'Medium is not selected';
            } elseif ($classes->medium == 1) {
                $medium = 'Sinhala';
            } elseif ($classes->medium == 2) {
                $medium = 'English';
            } elseif ($classes->medium == 3) {
                $medium = 'Tamil';
            }  else {
                $medium = 'Unknown';
            }

            if ($classes->class == 0) {
                $class = 'class is not selected';
            } elseif ($classes->class == 1) {
                $class = 'A';
            } elseif ($classes->class == 2) {
                $class = 'B';
            } elseif ($classes->class == 3) {
                $class = 'C';
            } elseif ($classes->class == 4) {
                $class = 'D';
            }  else {
                $class = 'Unknown';
            }


            $classlist[] =[
                'id' => $classes->id,
                'grade' => $classes -> grade,
                'class' => $class,
                'medium' => $medium,
                'stream' => $stream,
            ];
        }
        return response()->json(['classList' => $classlist]);
    
    }


    public function deleteClass($id){

        classManagement::where(['id'=>$id,])->delete();

        return response()->json(['success' => 'Class deleted']);

    }
}
