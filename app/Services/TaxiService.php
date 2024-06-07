<?php

namespace App\Services;

use App\Contracts\BuyInterface;
use App\Models\Taxi;
use App\Models\User;
use App\Models\UserTaxi;
use Illuminate\Support\Facades\Auth;

class TaxiService implements BuyInterface
{
    private $taxi;

    private $user;

    public function __construct(Taxi $taxi)
    {
        $this->taxi = $taxi;
        $this->user = Auth::user();
    }

    public function validateAndBuy(): bool|string|null
    {
        if ($validate = $this->canBuy()) {
            return $validate;
        }
        return $this->buy();
    }

    private function buy(): bool
    {
        UserService::decreaseCredits($this->user, $this->taxi->price);

        $userTaxi = new UserTaxi();
        $userTaxi->user_id = $this->user->id;
        $userTaxi->taxi_id = $this->taxi->id;
        $userTaxi->price = $this->taxi->price;
        $userTaxi->color_id = $this->taxi->color->id;
        $userTaxi->save();

        return true;
    }

    public function canBuy(): ?string
    {
        if ($this->user->credit < $this->taxi->price) {
            return 'Недостаточно средств';
        }

        return null;
    }
}
