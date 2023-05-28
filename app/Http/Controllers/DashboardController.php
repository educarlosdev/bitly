<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use App\Models\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        $data = [
            'links' => $this->request->user()->links()->count(),
            'month_views' => $this->request->user()->links()->sum('views'),
            'week_views' => Hit::query()->whereIn('link_id', $this->request->user()->links->pluck('id'))->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'day_views' => Hit::query()->whereIn('link_id', $this->request->user()->links->pluck('id'))->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count(),
            'hour_views' => Hit::query()->whereIn('link_id', $this->request->user()->links->pluck('id'))->whereBetween('created_at', [now()->startOfHour(), now()->endOfHour()])->count(),
        ];
        return $data;
    }
}
