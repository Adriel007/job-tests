<?php

function blade($view, $data = [])
{
    $viewPath = __DIR__ . "/views/$view.blade.php";

    if (file_exists($viewPath)) {
        extract($data);

        ob_start();

        include $viewPath;

        return ob_get_clean();
    } else {
        return "View file not found: $view.blade.php";
    }
}
