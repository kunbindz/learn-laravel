<?php

namespace App\Http\Controllers;

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

    public function registerUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:5|max:20',
            'confirmPassword'=>'required|same:password'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $res = $user->save();

        if($res) {
            return redirect('/login')->with('success', 'You have registered successfully !');
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
                return redirect('dashboard');
            } else {
                return back()->with('fail', 'The password not matches.');
            }
        } else {
            return back()->with('fail', 'This email not registered.');
        }
    }

    public function dashboard()
    {
        $data = array();
        if(Session::has('loginId')) {
            $data = User::where('id', Session::get('loginId'))->first();
        }

        $client = new Client(['allow_redirects' => true]);
        $request = new \GuzzleHttp\Psr7\Request('GET', "https://tuan-store-uppromote.myshopify.com/admin/api/2024-07/products.json?vendor=partners-demo", [
            'X-Shopify-Access-Token' => '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'
        ]);
        $response = $client->send($request);
        $content = $response->getBody()->getContents();
        $shopifyData = json_decode($content, true);
        return view('dashboard', compact('data', 'shopifyData'));
    }

    public function deleteProduct(Request $request) {

    }

    public function logout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
