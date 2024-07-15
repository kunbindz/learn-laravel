<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserRequestequest as UserRequestequestAlias;
use App\Http\Requests\UserRequest;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function registerUser(UserRequest  $request)
    {

        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        $res = $user->save();

        if($res) {
            return redirect('/login')->with('registeredSuccess', 'You have registered successfully, login now !');
        } else {
            return back()->with('fail', 'Something wrong !');
        }

    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:20',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId', $user->id);
                $user = User::where('id', $user->id)->first();
                $request->session()->put('user', $user);
                return redirect('products');
            } else {
                return back()->with('fail', 'The password not matches.');
            }
        } else {
            return back()->with('fail', 'This email not registered.');
        }
    }

    public function logout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
