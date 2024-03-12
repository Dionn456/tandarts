<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
}
