<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register()
    {
        if (Auth::check()){
            return redirect(route('home'));
        }

        return view('account.register', ['pageTitle' => 'Register']);
    }

    public function store(UserRequest $request)
    {
        $acceptJson = $request->acceptsJson();

        $user = $request->createUser(true);
        if ($user && $user->exists){
            if ($acceptJson){
                return response()->json(['success' => true, 'redirect_to' => route('registered')]);
            } else {
                return redirect()->intended(route('registered'));
            }
        }

        $m = 'Register failed. Please try again later.';
        if ($acceptJson){
            return response()->json([
                "errors" => [
                    "message" => $m
                ]
            ], 422);
        } else {
            return back()->withErrors([
                'message' => $m,
            ]);
        }
    }

    public function registered()
    {
        return view('account.registered', ['pageTitle' => 'Registered']);
    }

    //
    public function login()
    {
        if (Auth::check()){
            return redirect(route('home'));
        }

        return view('account.login', ['pageTitle' => 'Login']);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials['is_active'] = true;

        $acceptJson = $request->acceptsJson();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($acceptJson){
                return response()->json(['success' => true, 'redirect_to' => route('home')]);
            } else {
                return redirect()->intended(route('home'));
            }
        }

        $notFoundMsg = 'The provided credentials do not match our records';
        if ($acceptJson){
            return response()->json([
                "errors" => [
                    "message" => $notFoundMsg
                ]
            ], 422);
        } else {
            return back()->withErrors([
                'message' => $notFoundMsg,
            ])->onlyInput('email');
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
