<?php 
session_start();

function dbcon(){

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=dot_todos', 'root', 'root');
    } catch (PDOException $e) {
        print "エラー：" . $e->getMessage() . "<br/>";
        exit();
    }
    return $pdo;
}
