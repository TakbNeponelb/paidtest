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

    public function testUpdateColorWithEnoughCredits()
    {
        $response = $this->setDB('<>');

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['success' => 'Машина перекрашена']);


    }

    public function testUpdateColorWithoutEnoughCredits()
    {
        $response = $this->setDB('<>', 1);

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['error' => 'Недостаточно средств']);


    }

    public function testFirstColorUpdate()
    {
        $response = $this->setDB('<>', 1, 1);

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['success' => 'Машина перекрашена']);


    }

    public function testNotUpdateToSameColor()
    {
        $response = $this->setDB();

        $response->assertRedirect(route('taxi.list'));
        $response->assertSessionHasAll(['error' => 'Цвет уже выбран']);
    }

    private function setDB($operator = null, $credit = null, $change_color = null)
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        if ($credit != null)
        {
            $user->credit = 0;
            $user->save();
        }

        Color::factory(3)->create();
        Taxi::factory(10)->create();

        $color = Color::first();
        if ($operator != null)
        {
            $taxi = Taxi::where('color_id', $operator, $color->id)->first();
        }
        else
        {
            $taxi = Taxi::where('color_id', $color->id)->first();
        }

        $userTaxi = UserTaxi::factory()->create([
            'user_id' => $user->id,
            'color_id' => $taxi->color_id,
            'taxi_id' => $taxi->id,
            'change_color' => $change_color ? 0 : 1,
        ]);

        $response = $this->post(route('color.update', ['taxi' => $userTaxi->id]), ['name' => $color->id]);

        return $response;
    }
}
