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
  </div

  <?php
  include("server.php");
  $id = uniqid();
  $item = $_POST["id"];
  $price = $_POST["price"];
  $name = $_POST["name"];
  if($price>0){
  $conn = new mysqli($servername,$username,$password,$database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

    $date = date("d.m.Y H:i");
    $sql = "insert into log_items(id,item,name,price,date,user) values('$id','$item','$name',$price,'$date','$user');";
    $conn->query($sql);

    $sql = "insert into log_money(id,type,date,amount,user) values('$id','sell','$date',$price,'$user');";
    $conn->query($sql);

    $sql = "update items set amount = amount-1 where id='$item';";
    $conn->query($sql);

    echo"<div class='alert alert-success'>Товар успешно продан!</div>";
  }
   else{
    echo"<div class='alert alert-danger'>Укажите цену!</div>";
  }
   ?>
</body>
</html>
