<?php
  session_start();
  $user = $_SESSION["user"];
  session_write_close();
if ($user==""){
      header('Location: login.php');
    }
     ?>

<!DOCTYPE html>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
   <div class="btn-group-sm row">
     <a type="button" href="add_item.php" class="btn btn-default col-xs-3">Добавить</a>
     <a type="button" href="list_item.php" class="btn btn-default col-xs-3">Склад</a>
     <a type="button" href="search.php" class="btn btn-default col-xs-3">Поиск</a>
     <a type="button" href="stats.php" class="btn btn-default col-xs-3">Статистика</a>
  </div>
</body>
</html>
