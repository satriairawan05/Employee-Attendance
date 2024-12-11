<?php

namespace App\Http\Controllers\API;

use App\Enums\Statuses;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('name','status','email','created_at as created_date')->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name'   => ['required', 'string'],
            'email'   => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4', 'max:8']
        ]);

        if (!$validated->fails()) {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => base64_encode($request->input('password')),
                'status' => Statuses::Active
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name'   => ['required', 'string'],
            'email'   => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:4', 'max:8']
        ]);

        if (!$validated->fails()) {
            User::where('id', $user->id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => base64_encode($request->input('password')),
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Update the status in storage.
     */
    public function updateStatus(Request $request, User $user)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status'   => ['required', 'string'],
        ]);

        if (!$validated->fails()) {
            User::where('id', $user->id)->update([
                'status' => $request->input('status') == 'active' ? Statuses::Active : Statuses::Inactive,
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
