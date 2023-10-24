<?php
/**
 * Функция для вывода имен файлов в каталоге, соответствующих заданному шаблону имени файла.
 *
 * Этот сценарий использует регулярные выражения для поиска файлов, имена которых состоят из цифр
 * и букв латинского алфавита и имеют расширение .ixt.
 *
 * @param string $directory Путь к каталогу, в котором будут искаться файлы.
 * @param string $pattern Шаблон имени файла.
 *
 * @return array Массив, содержащий имена найденных файлов, упорядоченных по имени.
 */
function listFilesMatchingPattern($directory, $pattern)
{
    $files = scandir($directory);
    $matchingFiles = [];

    foreach ($files as $file) {
        if (preg_match($pattern, $file) === 1) {
            $matchingFiles[] = $file;
        }
    }

    sort($matchingFiles);

    return $matchingFiles;
}

// Путь к каталогу, в котором будут искаться файлы
$directory = '/datafiles';

// Шаблон имени файла, соответствующий числам, латинским буквам и расширению .ixt
$pattern = '/^[a-zA-Z0-9]+\.ixt$/';

$matchingFiles = listFilesMatchingPattern($directory, $pattern);

if (!empty($matchingFiles)) {
    echo "Найденные файлы:\n";
    foreach ($matchingFiles as $file) {
        echo $file . "\n";
    }
} else {
    echo "В каталоге не найдено файлов, соответствующих заданному шаблону.\n";
}

?>