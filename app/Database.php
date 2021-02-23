<?php 

class Database
{
    public static function dbcon(){

    try {
        $instance = new PDO('mysql:host=localhost;dbname=dot_todos', 'root', 'root');
    } catch (PDOException $e) {
        print "エラー：" . $e->getMessage() . "<br/>";
        exit();
    }
    return $instance;


}
       



}
