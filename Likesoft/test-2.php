<?php

/**
 * Function to extract and insert events from the bills.ru website into the database.
 */
function extractAndInsertEvents() {
    // URL страницы www.bills.ru
    $url = "https://www.bills.ru/";

    // Инициализация библиотеки cURL для загрузки страницы
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $pageContent = curl_exec($ch);

    // Проверка успешности загрузки страницы
    if ($pageContent === false) {
        die("Ошибка при загрузке страницы.");
    }

    // Используем регулярное выражение для извлечения событий из блока "события на долговом рынке"
    $pattern = '/<div class="debt-event">(.*?)<\/div>/s';
    if (preg_match_all($pattern, $pageContent, $matches)) {
        $events = $matches[1];

        // Установка соединения с базой данных (замените информацию о базе данных)
        $mysqli = new mysqli("localhost", "пользователь", "пароль", "имя_базы_данных");

        // Проверка соединения
        if ($mysqli->connect_error) {
            die("Ошибка соединения с базой данных: " . $mysqli->connect_error);
        }

        // Подготовка и выполнение SQL-запроса для вставки событий в таблицу
        $stmt = $mysqli->prepare("INSERT INTO bills_ru_events (date, title, url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $date, $title, $url);

        foreach ($events as $event) {
            // Используйте регулярные выражения для извлечения даты, заголовка и URL каждого события
            if (preg_match('/<span class="event-date">(.*?)<\/span>/', $event, $dateMatch) &&
                preg_match('/<a href="(.*?)"[^>]*>(.*?)<\/a>/', $event, $linkMatch)) {
                $date = date("Y-m-d H:i:s", strtotime($dateMatch[1]));
                $title = strip_tags($linkMatch[2]);
                $url = $linkMatch[1];

                // Выполнение вставки в таблицу
                $stmt->execute();
            }
        }

        // Закрытие запроса и соединения с базой данных
        $stmt->close();
        $mysqli->close();
    }

    // Закрытие соединения cURL
    curl_close($ch);
}

// Вызов функции для извлечения и вставки событий
extractAndInsertEvents();

?>
