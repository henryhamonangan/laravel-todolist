<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected $app;
    private UserService $userService;

    protected function setUp():void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("hamonangan", "perboden"));
    }

    public function testUserNotFound()
    {
        self::assertFalse($this->userService->login("bambang", "kuncoro"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("hamonangan", "salah"));
    }
}
