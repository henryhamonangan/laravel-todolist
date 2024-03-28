<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "hamonangan",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Hamonangan"
                ],
                [
                    "id" => "2",
                    "todo" => "Christian"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')->assertSeeText('Hamonangan')
            ->assertSeeText('2')->assertSeeText('Christian');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "hamonangan"
        ])->post("/todolist", [])->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "hamonangan"
        ])->post("/todolist", [
            "todo" => "Hamonangan"
        ])->assertRedirect("/todolist");
    }

    public function testDeleteTodolist()
    {
        $this->withSession([
            "user" => "hamonangan",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Hamonangan"
                ],
                [
                    "id" => "2",
                    "todo" => "Christian"
                ]
            ]
        ])->post("/todolist/1/delete")->assertRedirect("/todolist");
    }
}
