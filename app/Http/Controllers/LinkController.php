<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            ->when($this->request->has('q') && $this->request->has('q') != '', function (Builder $builder) {
                $builder->where(function (Builder $builder) {
                    $builder->whereFullText(['url', 'slug'], "+{$this->request->q}", ['mode' => 'boolean'])
                        ->orWhere('url', 'LIKE', "%{$this->request->q}%")
                        ->orWhere('slug', 'LIKE', "%{$this->request->q}%");
                });
            })
            ->paginate(4)
            ->withQueryString();

        return response()->json($links);
    }

    public function store()
    {
        $this->request->validate([
            'url' => ['required', 'url'],
            'slug' => ['min:6', 'max:8', 'string', Rule::unique(Link::class)],
        ]);

        $link = new Link;
        $link->fill($this->request->all());
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
            'slug' => ['required', 'min:6', 'max:8', 'string', Rule::unique(Link::class)->ignore($link->id)],
        ]);

        $link->fill($this->request->all());
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
