<?php
session_start();

//特殊文字対策
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//CSRF対策============================
function createToken()
{
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}

function validateToken()
{
  if (
    empty($_SESSION['token']) ||
    $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
  ) {
    exit('Invalid post request');
  }
}
//=====================================

//トークン生成
createToken();

//db接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dot_todos', 'root', 'root');
} catch (PDOException $e) {
    print "エラー：" . $e->getMessage() . "<br/>";
    exit();
}

//登録処理
function addTodo($pdo)
{
  $title = trim(filter_input(INPUT_POST, 'title'));
  if ($title === '') {
    return;
  }
  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  $stmt->execute();
}

//表示処理
function getResults($pdo)
{
    $sql = "SELECT * FROM todos ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    return $results;
}

//登録の実行（ポストがあった際実行される）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
    addTodo($pdo);
    header('Location: index.php');
    exit;
  }

//表示の実行
$results = getResults($pdo);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>php練習</h1>

    <form action="" method="post">
        <input type="text" name="title" placeholder="Type new todo.">
        <input type="hidden" name='token' value='<?=h($_SESSION['token']) ?>'>

    </form>
    <ul>
        <?php foreach ($results as $result) : ?>
            <li>
                <input type="checkbox" <?= $result['is_done']  ? 'checked' : ''; ?>>
                <span>
                    <?= $result['title']; ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>








</html>