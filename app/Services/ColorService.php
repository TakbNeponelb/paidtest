<?php

namespace App\Services;

use App\Models\UserTaxi;
use App\Models\Color;
use App\Contracts\BuyInterface;
use Illuminate\Support\Facades\Auth;

class ColorService implements BuyInterface
{
    private $color;
    private $userTaxi;
    private $user;
    private $cost = 1000;

    public function __construct(UserTaxi $userTaxi, Color $color)
    {
        $this->userTaxi = $userTaxi;
        $this->color = $color;
        $this->user = Auth::user();
    }

    public function validateAndBuy(): bool|string|null
    {
        $canBuy = $this->canBuy();
        if ($canBuy !== null) {
            return $canBuy;
        }

        return $this->buy();
    }

    private function buy()
    {

        $taxi = UserTaxi::findOrFail($this->userTaxi->id);

        if ($this->color->id == $taxi->color_id) {
            return 'Цвет уже выбран';
        } 
        else if ($taxi->change_color > 0 && $this->color->id != $taxi->color_id) {
            UserService::decreaseCredits($this->user, $this->cost);
        }

        $taxi->change_color += 1;
        $taxi->color_id = $this->color->id;
        $taxi->save();
        return null;
    }

    public function canBuy(): ?string
    {
        if (($this->user->credit < $this->cost) && ($this->userTaxi->change_color != 0)) {
            return 'Недостаточно средств';
        }

        return null;
    }
}
