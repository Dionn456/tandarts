<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     */
    public function current(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function index(): JsonResponse
    {
        $users = User::all(); 
        return response()->json($users);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = '4';
        $user->phone = '06123456789';
        $user->save();

        return redirect()->back();
    }

    
    public function getUser($userId): JsonResponse
    {
        $user = User::where('id', $userId)->first();
        
        return response()->json($user);
    }
}
