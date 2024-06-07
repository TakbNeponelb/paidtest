<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Taxi;
use App\Models\UserTaxi;
use App\Models\Color;

class ColorUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateWithEnoughCredits()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Color::factory(3)->create();
        Taxi::factory(10)->create();

        $color = Color::first();
        $taxi = Taxi::where('color_id', '<>', $color->id)->first();

        $userTaxi = UserTaxi::factory()->create([
            'user_id' => $user->id,
            'color_id' => $taxi->color_id,
            'taxi_id' => $taxi->id,
            'change_color' => 0,
        ]);

        $response = $this->post(route('color.update', ['taxi' => $userTaxi->id]), ['name' => $color->id]);

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['success' => 'Машина перекрашена']);


    }

    public function testUpdateWithoutEnoughCredits()
    {
        $user = User::factory()->create(['credit' => 500]);
        $this->actingAs($user);

        Color::factory(3)->create();
        Taxi::factory(10)->create();

        $color = Color::first();
        $taxi = Taxi::where('color_id', '<>', $color->id)->first();

        $userTaxi = UserTaxi::factory()->create([
            'user_id' => $user->id,
            'color_id' => $taxi->color_id,
            'taxi_id' => $taxi->id,
            'change_color' => 0,
        ]);

        $response = $this->post(route('color.update', ['taxi' => $userTaxi->id]), ['name' => $color->id]);

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['error' => 'Недостаточно средств']);
    }
}
