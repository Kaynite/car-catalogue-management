<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CarPolicy
{
    public function manage(User $user, Car $car): Response
    {
        return $car->user_id == $user->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
