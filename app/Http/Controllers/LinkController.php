<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $links = Link::query()
            ->userAuth(auth()->id())
            ->paginate(10)
            ->withQueryString();

        return response()->json($links);
    }

    public function store()
    {
        $this->request->validate([
            'url' => ['required', 'url'],
            'slug' => ['min:6', 'max:8', 'string'],
        ]);

        $link = new Link;
        $link->fill($this->request->validated());
        $link->save();

        return response()->json($link);
    }

    public function show(Link $link)
    {
        if ($link->user_id !== auth()->id()) {
                return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($link);
    }

    public function update(Link $link)
    {
        if ($link->user_id !== auth()->id()) {
                return response()->json(['message' => 'Not found'], 404);
        }

        $this->request->validate([
            'url' => ['required', 'url'],
            'slug' => ['min:6', 'max:8', 'string'],
        ]);

        $link->fill($this->request->validated());
        $link->save();

        return response()->json($link);
    }

    public function destroy(Link $link)
    {
        if ($link->user_id !== auth()->id()) {
                return response()->json(['message' => 'Not found'], 404);
        }

        $link->delete();

        return response()->json([], 204);
    }
}
