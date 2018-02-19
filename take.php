<?php
  session_start();
  $user = $_SESSION["user"];
  $access = $_SESSION["access"];
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

  <?php
      $amount = intval($_POST["amount"]);
      $amount = $amount * (-1);

      if (($amount!=0)&($access=="1")){
        $id = uniqid();



        include("server.php");



        $conn = new mysqli($servername,$username,$password,$database);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $date = date("d.m.Y H:i");

        $sql = "insert into log_money(id,type,date,amount,user) values('$id','take','$date',$amount,'$user');";
        $conn->query($sql);

        echo"<div class='alert alert-success'>Сумма вычтена из кассы!</div>";

}
     ?>

   <div class="btn-group-sm row">
     <a type="button" href="add_item.php" class="btn btn-default col-xs-3">Добавить</a>
     <a type="button" href="list_item.php" class="btn btn-default col-xs-3">Склад</a>
     <a type="button" href="search.php" class="btn btn-default col-xs-3">Поиск</a>
     <a type="button" href="stats.php" class="btn btn-default col-xs-3">Статистика</a>
  </div>

  <form method="post" >

    <label>Количество</label>
    <input type="number" class="form-control" name="amount" />
    </br>

    <input type="submit" class="btn btn-default" value="Вывести">
  </form>
</body>
</html>
