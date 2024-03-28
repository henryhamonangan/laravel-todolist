<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    protected $app;
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Hamonangan");

        $todolist = Session::get("todolist");
        foreach ($todolist as $todo) {
            self::assertEquals("1", $todo["id"]);
            self::assertEquals("Hamonangan", $todo["todo"]);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id"=> "1",
                "todo"=> "Hamonangan",
            ],
            [
                "id"=> "2",
                "todo"=> "Christian",
            ]
        ];

        $this->todolistService->saveTodo("1", "Hamonangan");
        $this->todolistService->saveTodo("2", "Christian");

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testDeleteTodo()
    {
        $this->todolistService->saveTodo("1", "Hamonangan");
        $this->todolistService->saveTodo("2", "Christian");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->deleteTodo("3");
        
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->deleteTodo("1");
        
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->deleteTodo("2");
        
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
