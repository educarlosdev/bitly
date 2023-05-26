<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function update(User $user)
    {
        $this->request->validate([
            'name' => ['string', 'max:255'],
        ]);

        $user->fill($this->request->only('name'));

        $user->save();

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([], 204);
    }
}
