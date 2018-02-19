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


      $name = $_POST["name"];
      $code = $_POST["code"];
      $size = intval($_POST["size"]);
      $color = $_POST["color"];
      $price_low = intval($_POST["price_low"]);
      $price_high = intval($_POST["price_high"]);
      $amount = intval($_POST["amount"]);

      if (($name!="")&($price_high>0)&($amount>0)){
        $id = uniqid();

        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/shopms.ru/images/";
        $image = $uploaddir . basename($_FILES['image']['name']);
        $image_loc = "/shopms.ru/images/" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
        } else {
        }



        include("server.php");



        $conn = new mysqli($servername,$username,$password,$database);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $sql = "insert into items(id,name,code,size,color,price_low,price_high,amount,photo) values('$id','$name','$article',$size,'$color',$price_low,$price_high,$amount,'$image_loc');";
        $result = $conn->query($sql);
        echo $conn->error;
        echo"<div class='alert alert-success'>Товар добавлен!</div>";

}
     ?>

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
<?php
  if(($access=="1")|($access=="2")){
    echo"<label>Себестоимость</label>
    <input type=\"number\" class=\"form-control\" name=\"price_low\"/>
    </br>";
  }
?>


    <label>Цена</label>
    <input type="number" class="form-control" name="price_high"/>
    </br>

    <label>Количество</label>
    <input type="number" class="form-control" name="amount" value="1"/>
    </br>

    <label>Фото</label>
    <input type="file" capture="camera" name="image" />
  </br>

    <input type="submit" class="btn btn-default" value="Добавить товар">
  </form>
</body>
</html>
