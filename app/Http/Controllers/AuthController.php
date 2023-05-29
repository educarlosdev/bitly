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

    public function login()
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
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $token = $user->createToken($user->id);

        return response()->json(['email' => $user->email, 'access_token' => $token->plainTextToken]);
    }

    public function register()
    {
        $this->request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
        ]);

        $user = new User;
        $user->fill($this->request->all());
        $user->password = Hash::make($this->request->password);
        $user->save();

        return response()->json(['email' => $user->email]);
    }

    public function logout()
    {
        $this->request->user()->tokens()->delete();

        return response()->json([], 204);
    }

    public function me()
    {
        return response()->json($this->request->user());
    }

    public function changePassword()
    {
        $validated = $this->request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);

        $this->request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([], 204);
    }
}
