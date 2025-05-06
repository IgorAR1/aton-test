<?php


//if (!function_exists('dd')) {
//    function dd(...$values): never
//    {
//        echo '<pre>';
//        foreach ($values as $value) {
//            var_dump($value);
//        }
//        echo '</pre>';
//
//        die();
//    }
//}


if (!function_exists('session')) {
    function session(string $key): ?array
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

       return null;
    }
}