<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Get authenticated user.
     */
    public function current(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::with("role"); 

        if ($request->has('role_id')) {
            $users->where("role_id", $request->role_id);
        }
        $users = $users->get();
        return response()->json( $users );
    }

    public function guestIndex()
    {
        $users = User::with("role")->where("role_id", 2)->get();
        return response()->json( $users);
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

        $useruser = new UserUser();
        $useruser->user_id = $user->id;
        $useruser->link_user_id = $request->dentist_id;
        $useruser->role_id = $request->role_id;
        $useruser->save();


        return redirect()->back();
    }

    public function updateUser(Request $request): JsonResponse
    {
        $user = User::find($request->id);

        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if (strlen($request->password) >= 4) $user->password = Hash::make($request->password);
        $user->save();

        $address = ($h = Address::where('id', $user->id)->first()) ? $h : new Address;
        $address->id = $address->id;
        $address->zip_code = $request->address["zip_code"];
        $address->city = $request->address["city"];
        $address->street = $request->address["street"];
        $address->number = $request->address["number"];
        $address->save();

        return response()->json($user);
    }

    
    public function getUser($userId): JsonResponse
    {
        $user = User::where('id', $userId)->first();
        
        return response()->json($user);
    }

    public function destroy($userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return response()->json(['message' => 'Room deleted successfully']);
    }
}
