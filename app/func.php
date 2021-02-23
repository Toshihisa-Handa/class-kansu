<?php




//登録処理
function addTodo($pdo)
{
  $title = trim($_POST['title']);
  if ($title === '') {
    return;
  }
  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue('title', Utils::h($title), PDO::PARAM_STR);
  $stmt->execute();
}

function toggleTodo($pdo){
  $id = $_POST['id'];
  if(empty($id)){
      return;
  }
$stmt = $pdo->prepare("UPDATE todos SET is_done = NOT is_done  WHERE id = :id");
$stmt->bindvalue('id', $id, PDO::PARAM_INT);
$stmt->execute();


}

function deleteTodo($pdo){
  $id = $_POST['id'];
  if(empty($id)){
      return;
  }
$stmt = $pdo->prepare("DELETE FROM todos WHERE id =:id");
$stmt->bindvalue('id', $id, PDO::PARAM_INT);
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

