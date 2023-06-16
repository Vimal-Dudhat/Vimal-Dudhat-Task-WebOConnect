<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function uniqueEmail(Request $request)
    {
        $user = User::where('email',$request->email);
        if ($user->count() == 1) {
            echo(json_encode(false));
        }else{
            echo(json_encode(true));
        }
    }
    
    public function edit(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if ($user &&  $user->is_qr_generate == 1) {
            $user->is_qr_generate = 0;
            $user->save();
            return view('user-update',compact('user'));
        }
        return redirect('/');
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $imageName = $user->profile_img;
            if ($request->hasFile('profile_img')) {
                if ($imageName && file_exists(public_path('/images/'.$imageName))) {
                    unlink(public_path('/images/'.$imageName));
                }
                $image = $request->file('profile_img');
                $imageName = rand(100000,999999).time().'.'.$image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
            }
            //  Update user
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->profile_img = $imageName;
            $user->save();
    
            return response()->json(['status' => 200, 'message' => 'User Updated Successfully.', 'success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th, 'success' => false]);
        }
    }
}
