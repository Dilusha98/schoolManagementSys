<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\UserManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagmentController extends Controller
{
    public function index()  
    {
        return view('admin.UserManagment');
    }

    //save user
    public function saveUser(UserValidationRequest $request)
    {
        $input = $request->validated();

        UserManagment::create([
            'role'=> $input['roleSelect'],
            'userFirstName'=> $input['userFirstName'],
            'userLastName'=> $input['userLastName'],
            'userEmail'=> $input['userEmail'],
            'userAddress'=> $input['userAddress'],
            'userTelephone'=> $input['userTelephone'],
            'UserUserName'=> $input['UserUserName'],
            'userDOB'=> $input['userDOB'],
            'userGender'=> $input['userGender'],
            'userPassword'=> bcrypt($input['userPassword']),
        ]);
        return response()->json(['success' => 'User Added Successfully']);
    }

    // view user
    public function ViewUserList()
    {
        $userslist = DB::table('user_managments')
        ->select('*')
        ->get();

        $usersList = [];
        foreach ($userslist as $user) {
            $role = ($user->role == 1) ? 'Admin' : 'Teacher';
    
            $usersList[] = [
                'id' => $user->id,
                'role' => $role,
                'userFirstName' => $user->userFirstName,
                'userLastName' => $user->userLastName,
                'userEmail' => $user->userEmail,
                'userAddress' => $user->userAddress,
                'userTelephone' => $user->userTelephone,
                'userDOB' => $user->userDOB,
                'userGender' => $user->userGender,
            ];
        }

        return response()->json([
            'usersList' => $usersList,
        ]);
    }

    // delete user
    public function DeleteUser($id)
    {
        UserManagment::where([
            'id'=>$id,
        ])->delete();

        return response()->json([
            'success' => 'Employee deleted Successfully!'
        ]);
    }

    public function ViewUserListToEdit($id)
    {
        $userslisttoEdit = DB::table('user_managments')
        ->select('*')
        ->where('id',$id)
        ->get();

        return response()->json([
            'usersListtoEdit' => $userslisttoEdit,
        ]);
    }

    public function UpdateUserDetails(Request $request,$id)
    {
        UserManagment::where([
            'id' => $id,
        ])->update([
            'role'=> $request['roleSelect'],
            'userFirstName'=> $request['userFirstName'],
            'userLastName'=> $request['userLastName'],
            'userEmail'=> $request['userEmail'],
            'userAddress'=> $request['userAddress'],
            'userTelephone'=> $request['userTelephone'],
            'UserUserName'=> $request['UserUserName'],
            'userDOB'=> $request['userDOB'],
            'userGender'=> $request['userGender'],
        ]);
        return response()->json([
            'success' => 'User Details Updated Successfully!'
        ]);
    }
}
