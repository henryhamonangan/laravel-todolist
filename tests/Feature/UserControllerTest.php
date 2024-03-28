<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText("Login");
    }

    public function testLoginForMember()
    {
        $this->withSession([
            "user" => "hamonangan"
        ])->get('/login')->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "hamonangan",
            "password" => "perboden"
        ])->assertRedirect("/")->assertSessionHas("user", "hamonangan");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "hamonangan"
        ])->post('/login', [
            "user" => "hamonangan",
            "password" => "perboden"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "hamonangan"
        ])->post('/logout')->assertRedirect("/")->assertSessionMissing("user");
    }
    public function testLogoutGuest()
    {
        $this->post('/logout')->assertRedirect("/");
    }
}
