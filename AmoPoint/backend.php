<?php
// Подключение к базе данных MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных посетителя из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

// Подготовка запроса на вставку данных в таблицу посещений
$stmt = $conn->prepare('INSERT INTO visits (ip, city, device) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $data['ip'], $data['city'], $data['device']);

// Выполнение запроса
if ($stmt->execute()) {
    echo "Данные успешно сохранены в базе данных MySQL.";
} else {
    echo "Ошибка при сохранении данных в базе данных MySQL: " . $conn->error;
}

// Закрытие соединения с базой данных
$stmt->close();
$conn->close();