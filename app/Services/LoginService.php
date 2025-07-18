<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

Class LoginService
{
    /**
     * Coba login dengan kredensial yang diberikan.
     *
     * @param array $credentials
     * @return bool
     */
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}


?>