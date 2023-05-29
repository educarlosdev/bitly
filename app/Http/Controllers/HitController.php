<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class HitController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $hits = $this->__filter(Hit::query()->whereIn('link_id', $this->request->user()->links->pluck('id')));

        if ($this->request->has('export') && $this->request->get('export')) {
            return $this->__export($hits->get());
        }
        $hits = $hits->paginate(4)
            ->withQueryString();

        return response()->json($hits);
    }

    public function show($id)
    {
        $hits = $this->__filter(Hit::query()->where('link_id', $id));

        if ($this->request->has('export') && $this->request->get('export')) {
            return $this->__export($hits->get());
        }
        $hits = $hits->paginate(4)
            ->withQueryString();

        return response()->json($hits);
    }

    private function __filter($model)
    {
        return $model->when($this->request->has('q') && $this->request->get('q') != '', function (Builder $builder) {
            $builder->where(function (Builder $builder) {
                $builder->whereFullText('user_agent', "+{$this->request->q}", ['mode' => 'boolean'])
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
            });
    }

    private function __export($data)
    {
        (new FastExcel($data))->export("{$this->request->user()->id}.xlsx", function ($hit) {
            $userAgent = collect($hit->parse_user_agent)->toArray();
            return [
                'IP' => $hit->ip,
                'Dispositivo' => $userAgent['deviceModel'],
                'Navegador' => $userAgent['browserFamily'],
                'Evento' => "Há {$hit->created_formatted}",
            ];
        });

        rename(public_path("{$this->request->user()->id}.xlsx"), Storage::disk('public')->path("temp/{$this->request->user()->id}.xlsx"));

        return Storage::disk('public')->url("temp/{$this->request->user()->id}.xlsx");
    }
}
