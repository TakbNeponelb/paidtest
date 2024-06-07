<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Taxi;


interface BuyInterface
{
    public function validateAndBuy();

    public function canBuy();
}