<?php

namespace MyApp;

class Database
{
    private static $instance;
    public static function dbcon()
    {

        //self::はstaticの時に使用する
        if (!isset(self::$instance)) {
            try {
                self::$instance = new \PDO('mysql:host=localhost;dbname=dot_todos', 'root', 'root');
            } catch (\PDOException $e) {
                print "エラー：" . $e->getMessage() . "<br/>";
                exit();
            }
            return self::$instance;
        }
    }
}
