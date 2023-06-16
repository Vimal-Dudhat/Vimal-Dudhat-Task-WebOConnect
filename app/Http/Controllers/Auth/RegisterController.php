<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $imageName = null;
            if ($request->hasFile('profile_img')) {
                $image = $request->file('profile_img');
                $imageName = rand(100000,999999).time().$image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);    
            }
            //  Create new user
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->profile_img = $imageName;
            $user->save();
    
            return response()->json(['status' => 200, 'message' => 'User Created Successfully.', 'success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th, 'success' => false]);
        }
    }
}
