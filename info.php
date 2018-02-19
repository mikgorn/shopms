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

  <?php
  include("server.php");
  $id = $_GET["id"];
  $conn = new mysqli($servername,$username,$password,$database);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "select * from items where id='$id';";
  $result = $conn->query($sql);
  if(mysqli_num_rows($result)>0){
  $row = $result->fetch_assoc();
    $name = $row["name"];
    $code = $row["code"];
    $size = $row["size"];
    $color = $row["color"];
    $price_high = $row["price_high"];
    $amount = $row["amount"];
    $photo = $row["photo"];
    if($photo!=""){
      echo"<img src='$photo' width='100%'/>";
    }
  } else{
    echo"<div class='alert alert-danger'>Item does not exists!</div>";
  }
   ?>

   <br />
   <label>Название</label>
   <p><?php echo"$name"?></p>
   <br />

   <label>Артикл</label>
   <p><?php echo"$code"?></p>
   <br />

   <label>Цвет</label>
   <p><?php echo"$color"?></p>
   <br />

   <label>Размер</label>
   <p><?php echo"$size"?></p>
   <br />

   <label>Цена</label>
   <p><?php echo"$price_high"?></p>
   <br />

   <label>Количество</label>
   <p><?php echo"$amount"?></p>
   <br />

   <form action="sell.php" method="post" >
     <label>Цена</label>
     <input type="number" name="price" value="<?php echo"$price_high";?>"/>
     <input type="hidden"name="id" value=<?php echo"$id";?>>
     <input type="hidden"name="name" value=<?php echo"$name $code";?>>
     <input type="submit" class="btn btn-default" value="Продать">
   </form>

</body>
</html>
