<?php 
class ConcertoFactory {
    public static $concerto_template; 

    public static function bind($name, $pdo) {
        $getpdo = function () use ($pdo) { return $pdo; };
        return eval(str_replace("{{NAME}}", $name, self::$concerto_template));
    }
}

ConcertoFactory::$concerto_template = file_get_contents("concerto.template.php");
