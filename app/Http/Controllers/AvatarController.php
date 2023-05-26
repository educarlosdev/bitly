<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {
        $this->request->validate([
            'avatar' => ['image', 'mimes:jpg,jpeg,png,svg,webp', 'max:10240'],
        ]);

        Storage::disk('public')->put("users/{$this->request->user()->id}.jpg", $this->request->file('avatar')->getContent());

        return response()->json($this->request->user()->fresh());
    }

    public function destroy(User $user)
    {
        if (Storage::disk('public')->exists("users/{$this->request->user()->id}.jpg")) {
            Storage::disk('public')->delete("users/{$this->request->user()->id}.jpg");
        }

        return response()->json($this->request->user()->fresh());
    }
}
