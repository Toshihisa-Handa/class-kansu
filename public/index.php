<?php
include(__DIR__ . '/../app/config.php');

//db
$pdo = Database::dbcon();



$todo = new  Todo($pdo);
$todo->processPost();
$results = $todo->getResults();//表示の実行






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
    <input type="hidden" name='token' value='<?= Utils::h($_SESSION['token']) ?>'>

  </form>
  <ul>
    <?php foreach ($results as $result) : ?>
      <li>
        <form action="?action=toggle" method='post'>
          <input type="checkbox" <?= $result['is_done']  ? 'checked' : ''; ?>>
          <input type="hidden" name="id" value="<?= Utils::h($result['id']); ?>">
          <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
        </form>
        <span>
          <span class="<?= $result['is_done'] ? 'done' : ''; ?>">
            <?= $result['title']; ?>
          </span>

          <form action="?action=delete" method="post">
            <span class="delete">x</span>
            <input type="hidden" name="id" value="<?= Utils::h($result['id']); ?>">
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
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