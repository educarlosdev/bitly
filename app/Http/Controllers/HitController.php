<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HitController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $hits = Hit::query()
            ->whereIn('link_id', $this->request->user()->links->pluck('id'))
            ->when($this->request->has('q') && $this->request->get('q') != '', function (Builder $builder) {
                $builder->where(function (Builder $builder) {
                    $builder->whereFullText(['ip', 'user_agent'], "+{$this->request->q}", ['mode' => 'boolean'])
                        ->orWhere('ip', 'LIKE', "%{$this->request->q}%")
                        ->orWhere('user_agent', 'LIKE', "%{$this->request->q}%");
                });
            })
            ->when($this->request->has('order')
                && $this->request->get('order') != ''
                && $this->request->has('direction')
                && $this->request->get('direction') != '', function (Builder $builder) {
                $builder->orderBy($this->request->get('order'), $this->request->get('direction'));
            })
            ->when((!$this->request->has('order')
                    || $this->request->get('order') == '')
                || (!$this->request->has('direction')
                    || $this->request->get('direction') == ''), function (Builder $builder) {
                $builder->orderByDesc('created_at');
            })
            ->paginate(4)
            ->withQueryString();

        return response()->json($hits);
    }

    public function show($id)
    {
        $hits = Hit::query()
            ->where('link_id', $id)
            ->when($this->request->has('q') && $this->request->get('q') != '', function (Builder $builder) {
                $builder->where(function (Builder $builder) {
                    $builder->whereFullText(['ip', 'user_agent'], "+{$this->request->q}", ['mode' => 'boolean'])
                        ->orWhere('ip', 'LIKE', "%{$this->request->q}%")
                        ->orWhere('user_agent', 'LIKE', "%{$this->request->q}%");
                });
            })
            ->when($this->request->has('order')
                && $this->request->get('order') != ''
                && $this->request->has('direction')
                && $this->request->get('direction') != '', function (Builder $builder) {
                $builder->orderBy($this->request->get('order'), $this->request->get('direction'));
            })
            ->when((!$this->request->has('order')
                    || $this->request->get('order') == '')
                || (!$this->request->has('direction')
                    || $this->request->get('direction') == ''), function (Builder $builder) {
                $builder->orderByDesc('created_at');
            })
            ->paginate(4)
            ->withQueryString();

        return response()->json($hits);
    }
}
