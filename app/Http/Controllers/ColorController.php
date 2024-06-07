<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Services\ColorService;
use App\Models\Color;
use App\Models\UserTaxi;

class ColorController extends Controller
{
    public function update(ColorRequest $request, $userTaxi)
    {
        
        $color = Color::findOrFail((int) $request->validated('name'));
        $taxi = UserTaxi::findOrFail($userTaxi);

        $colorService = new ColorService($taxi, $color);
        $proccess = $colorService->validateAndBuy();
        

        if ($proccess !== null) {
            return redirect()->route('taxi.list')->with('error', $proccess);
        }

        return to_route('taxi.list')->with('success', "Машина перекрашена");
    }
}
