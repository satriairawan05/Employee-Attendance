<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email'   => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:4', 'max:8']
        ]);

        if (!$validated->fails()) {
            $credentials = ['email' => $request->input('email'), 'password' => base64_encode($request->input('password'))];
            if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
                \Illuminate\Support\Facades\Log::info('User dengan email ' . $request->input('email') . ' telah berhasil login di sistem!');

                return response()->json([
                    'status' => 'success',
                    'data' => \App\Models\User::select(['id', 'name', 'email', 'status'])->where('email', $request->input('email'))->first()
                ]);
            }
            $this->getResponse('error', 'Unauthorized', 401);
        } else {
            \Illuminate\Support\Facades\Log::error($validated->getMessageBag());
            $this->getResponse('error', $validated->getMessageBag());
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
