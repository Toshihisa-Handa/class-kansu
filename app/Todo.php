<?php

namespace MyApp;

class Todo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        //トークン生成
        Token::create();
    }

    //表示処理
    public function processPost()
    {


        //登録の実行（ポストがあった際実行される）
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Token::validate();
            $action = filter_input(INPUT_GET, 'action');

            switch ($action) {
                case 'add':
                    $this->add();
                    break;
                case 'toggle':
                    $this->toggle();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'deleteAll':
                    $this->deleteAll();
                    break;

                default:
                    exit;
            }

            header('Location: index.php');
            exit;
        }
    }



    //登録処理
    private function add()
    {
        $title = trim($_POST['title']);
        if ($title === '') {
            return;
        }
        $stmt = $this->pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
        $stmt->bindValue('title', Utils::h($title), \PDO::PARAM_STR);
        $stmt->execute();
    }

    private function toggle()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            return;
        }
        $stmt = $this->pdo->prepare("UPDATE todos SET is_done = NOT is_done  WHERE id = :id");
        $stmt->bindvalue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function delete()
    {
        $id = $_POST['id'];
        if (empty($id)) {
            return;
        }
        $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id =:id");
        $stmt->bindvalue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function deleteAll()
    {

        $stmt = $this->pdo->query("DELETE FROM todos WHERE is_done = 1");
    }









    function getResults() //元はgetAllで説明
    {
        $sql = "SELECT * FROM todos ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        $results = $stmt->fetchAll();
        return $results;
    }
}
