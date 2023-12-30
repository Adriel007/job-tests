<?php
require_once './database/conn.php';

class ApiController
{
    private $id;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function index()
    {
        if ($this->id !== null) {
            $task = $this->getTaskById($this->id);
            if ($task) {
                echo json_encode($task);
            } else {
                echo json_encode(['error' => 'Task not found']);
            }
        } else {
            $tasks = $this->getAllTasks();
            echo json_encode($tasks);
        }
    }

    private function getAllTasks()
    {
        global $dsn, $user, $password;

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $pdo->prepare("SELECT * FROM tasks");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error']);
            return [];
        }
    }

    private function getTaskById($taskId)
    {
        global $dsn, $user, $password;

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
            $statement->bindParam(':id', $taskId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database error']);
            return null;
        }
    }
}