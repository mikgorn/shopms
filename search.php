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
  <form method="post" enctype="multipart/form-data">
    <label>Название</label>
    <input type="text" class="form-control" name="name"/>
    </br>

    <label>Артикул</label>
    <input type="text" class="form-control" name="code"/>
    </br>

    <label>Размер</label>
    <input type="number" class="form-control" name="size"/>
    </br>

    <label>Цвет</label>
    <input type="text" class="form-control" name="color"/>
    </br>


    <input type="submit" class="btn btn-default" value="Поиск">
  </form>

  <?php
  $name = $_POST["name"];
  $code = $_POST["code"];
  $size = intval($_POST["size"]);
  $color = $_POST["color"];


    if(($user!="")&(($size>0)|($name.$code.$color!=""))){
        include("server.php");
        $conn = new mysqli($servername,$username,$password,$database);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        if($size>0){
          $sql = "select * from items where name like '%$name%' and code like '%$code%' and color like '%$color%' and size=$size and amount>0;";
        }else{
        $sql = "select * from items where name like '%$name%' and code like '%$code%' and color like '%$color%' and amount>0;";
      }
        $result = $conn->query($sql);
        if(mysqli_num_rows($result)>0){
          echo"<table class='table table-striped'>
    <thead>
      <tr>
        <th>Название</th>
        <th>Артикул</th>
        <th>Цена</th>
        <th>Подробнее</th>
      </tr>
    </thead>
    <tbody>";
          while($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $code = $row["code"];
            $price = $row["price_high"];
            $id = $row["id"];
            echo"
            <tr>
              <td>$name</td>
              <td>$code</td>
              <td>$price</td>
              <td><a class='btn btn-default' href='info.php?id=$id'>Подробнее</a></td>
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
</body>
</html>
