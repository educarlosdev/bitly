<?php

namespace Database\Factories;

use App\Models\Hit;
use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class HitFactory extends Factory
{
    protected $model = Hit::class;

    public function definition()
    {
        $link = Link::query()->inRandomOrder()->first();
        $link->increment('views');
        return [
            'link_id' => $link->id,
            'ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
