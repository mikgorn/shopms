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
   <div class="btn-group-sm row">
     <a type="button" href="add_item.php" class="btn btn-default col-xs-3">Добавить</a>
     <a type="button" href="list_item.php" class="btn btn-default col-xs-3">Склад</a>
     <a type="button" href="search.php" class="btn btn-default col-xs-3">Поиск</a>
     <a type="button" href="stats.php" class="btn btn-default col-xs-3">Статистика</a>
  </div>

    <h3>Продажи за день</h3>
<?php
echo"$user $access";
if($user!=""){
    include("server.php");
    $conn = new mysqli($servername,$username,$password,$database);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $today= date("d.m.Y");
    $sql = "select * from log_items where date like '%$today%';";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result)>0){
      echo"<table class='table table-striped'>
<thead>
  <tr>
    <th>Название</th>
    <th>Цена</th>
    <th>Продавец</th>
    <th>Подробнее</th>
  </tr>
</thead>
<tbody>";
      while($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $price = $row["price"];
        $admin = $row["user"];
        $id = $row["id"];
        $item = $row["item"];
        echo"
        <tr>
          <td>$name</td>
          <td>$price</td>
          <td>$admin</td>
          <td><a class='btn btn-default' href='info.php?id=$item'>Подробнее</a></td>
        </tr>
        ";

      }

      echo"

          </tbody>
        </table>";

    }
    else{
      echo"<div class='alert alert-danger'>Нет предметов на складе!</div>";
    }
  }
?>
</br>
  <h3>Касса</h3>
  <?php
    if(($access=="1")|($access=="2")){
      echo" <a type=\"button\" href=\"take.php\" class=\"btn btn-default col-xs-3\">Вывести</a>
      <a type=\"button\" href=\"add.php\" class=\"btn btn-default col-xs-3\">Добавить</a>
      </br>";
    }
  ?>
<?php
$sql = "select SUM(amount) as sum from log_money;";
$result = $conn->query($sql);
$row= $result->fetch_assoc();
$sum = $row["sum"];
echo "</br><h4 class='bg-success'>$sum</h4>";

$sql = "select * from log_money order by id desc limit 10;";
$result = $conn->query($sql);
if(mysqli_num_rows($result)>0){
  echo"<table class='table table-striped'>
<thead>
<tr>
<th>Тип</th>
<th>Сумма</th>
<th>Дата</th>
<th>Админ</th>
</tr>
</thead>
<tbody>";
  while($row = $result->fetch_assoc()) {
    $type = $row["type"];
    $amount = $row["amount"];
    $admin = $row["user"];
    $date = $row["date"];
    $item = $row["item"];
    $type_ru = $type;
    switch($type){
      case "sell":
        $type_ru="Продажа";
        break;
      case "take":
        $type_ru="Вывод";
        break;
      case "add":
        $type_ru="Ввод";
        break;
    }
    echo"
    <tr>
      <td>$type_ru</td>
      <td>$amount</td>
      <td>$date</td>
      <td>$admin</td>
    </tr>
    ";

  }

  echo"

      </tbody>
    </table>";

}
else{
  echo"<div class='alert alert-danger'>Нет предметов на складе!</div>";
}

 ?>




</body>
</html>
