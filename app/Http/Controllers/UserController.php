<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use LogicException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $role = $request->query('role');
        $user = new User();
        if (in_array($role, ['admin', 'user'])){
            $isAdmin = $role == 'admin' ? true:false;
            $user = $user->where(['is_admin' => $isAdmin]);
        }
        $users = $user->orderBy('id', 'DESC')->get();
        return view('account.list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('account.form', ['user' => new User(), 'pageTitle' => 'Add User']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $acceptJson = $request->acceptsJson();

        $newUser = $request->createUser();
        if ($newUser && $newUser->exists){
            $request->session()->flash('user_message', ['type' => 'success', 'text' => 'User ('.$newUser->name.') successfully added.']);
            if ($acceptJson){
                return response()->json(['success' => true, 'redirect_to' => route('user.index')]);
            } else {
                return redirect()->intended(route('user.index'));
            }
        }

        $m = 'Fail to add new user.';
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        return view('account.form', ['user' => $user, 'pageTitle' => 'Edit User']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $acceptJson = $request->acceptsJson();

        $formData = $request->safe();

        $user->email = $formData['email'];
        $user->name  = $formData['name'];
        if ($formData['password']){
            $user->password = $formData['password'];
        }
        if ($user->id != $request->user()->id){
            $user->is_admin  = (bool) $request->post('is_admin', false);
            $user->is_active = (bool) $request->post('is_active', false);
        }

        if ($user->save()){
            if ($user->id == $request->user()->id){
                return response()->json(['success' => true, 'message' => 'Your profile successfully updated.']);
            }
            $request->session()->flash('user_message', ['type' => 'success', 'text' => 'User ('.$user->name.') successfully updated.']);
            if ($acceptJson){
                return response()->json(['success' => true, 'redirect_to' => route('user.index')]);
            } else {
                return redirect()->intended(route('user.index'));
            }
        }

        $m = 'Fail to add edit user.';
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ?User $user)
    {
        //
        $error = null;
        if ($user && $user->exists){
            try{
                $result = $user->delete();
                if ( !$result){
                    $error = 'User failed to delete.';
                }
            } catch (Exception $e){
                $error = $e->getMessage();
            }
        } else {
            $userIds = $request->input('id');
            if ($userIds){
                try {
                    $result = User::destroy($userIds);
                    if ( !$result){
                        $error = 'User failed to delete.';
                    }
                } catch (Exception $e){
                    $error = $e->getMessage();
                }
            } else {
                $error = 'No user to be deleted.';
            }
        }

        if ( !$error){
            $request->session()->flash('user_message', ['type' => 'success', 'text' => 'User successfully deleted.']);
            return response()->json(['success' => true]);
        }

        return response()->json(['message' => $error], 422);
    }

    public function me(){
        return view('account.me');
    }
}
