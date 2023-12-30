<?php
require_once './blade.php';
require_once './controllers/ApiController.php';

class TaskController
{
    private $taskId;

    public function setId($id)
    {
        $this->taskId = $id;
    }

    public function index()
    {
        $tasks = ApiController::getAllTasks();
        $totalPages = ceil(count($tasks) / 10);
        echo blade('page', compact('tasks', 'totalPages'));
    }
}
