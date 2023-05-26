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
        return [
            'link_id' => Link::query()->inRandomOrder()->first()->id,
            'ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
