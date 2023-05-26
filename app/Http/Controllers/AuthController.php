<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {
        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('email', $this->request->email)
            ->first();

        if (!$user || !Hash::check($this->request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($user->id);

        return response()->json(['email' => $user->email, 'access_token' => $token->plainTextToken]);
    }

    public function show()
    {
        return response()->json($this->request->user());
    }

    public function destroy()
    {
        $this->request->user()->tokens()->delete();

        return response()->json([], 204);
    }
}
