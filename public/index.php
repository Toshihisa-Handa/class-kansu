<?php
include(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/func.php');

//db
$pdo = dbcon();



//トークン生成
createToken();





//登録の実行（ポストがあった際実行される）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  validateToken();
  $action = filter_input(INPUT_GET, 'action');

  switch ($action) {
    case 'add':
      addTodo($pdo);
      break;
    case 'toggle':
      toggleTodo($pdo);
      break;
      case 'delete':
        deleteTodo($pdo);
      break;
      default:
      exit;
  }

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
  <style>
    li {
      display: flex;
    }

    .done {
      text-decoration: line-through;
      color: #ccc;
    }

    .delete {
      color: #ccc;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <h1>php練習</h1>

  <form action="?action=add" method="post">
    <input type="text" name="title" placeholder="Type new todo.">
    <input type="hidden" name='token' value='<?= h($_SESSION['token']) ?>'>

  </form>
  <ul>
    <?php foreach ($results as $result) : ?>
      <li>
        <form action="?action=toggle" method='post'>
          <input type="checkbox" <?= $result['is_done']  ? 'checked' : ''; ?>>
          <input type="hidden" name="id" value="<?= h($result['id']); ?>">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <span>
          <span class="<?= $result['is_done'] ? 'done' : ''; ?>">
            <?= $result['title']; ?>
          </span>

          <form action="?action=delete" method="post">
            <span class="delete">x</span>
            <input type="hidden" name="id" value="<?= h($result['id']); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
          </form>



      </li>
    <?php endforeach; ?>
  </ul>






  <script>
    {
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
          checkbox.parentNode.submit();
        });
      });
    }


  const deletes = document.querySelectorAll('.delete');
  deletes.forEach(span => {
    span.addEventListener('click', () => {
      if(!confirm('本当に消す？')){
        return;
      }
      span.parentNode.submit();
    });
  });

  </script>
</body>

</html>