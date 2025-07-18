<?php

namespace Tests\Unit;

use App\Services\LoginService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    /** @test */
    public function login_succeeds_with_correct_credentials()
    {
        // 🅰️ Arrange
        $credentials = [
            'email' => 'auliasabrina2023@gmail.com',
            'password' => 'liacantik61',
        ];

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(true);

        $service = new LoginService();

        // 🅰️ Act
        $result = $service->login($credentials);

        // 🅰️ Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function login_fails_with_wrong_password()
    {
        // 🅰️ Arrange
        $credentials = [
            'email' => 'auliasabrina2023@gmail.com',
            'password' => 'salahbanget',
        ];

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(false);

        $service = new LoginService();

        // 🅰️ Act
        $result = $service->login($credentials);

        // 🅰️ Assert
        $this->assertFalse($result);
    }
}
