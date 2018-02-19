<?php
$login = strtolower($_POST["login"]);
$pass = $_POST["password"];

include("server.php");
$conn = new mysqli($servername,$username,$password,$database);

$sql = "select * from users where login='$login';";
$result = $conn->query($sql);
if(mysqli_num_rows($result)>0){
  $row = $result->fetch_assoc();
  if($pass==$row["password"]){
    session_start();
  $_SESSION["user"] = $login;
  $_SESSION["access"] = $row["access"];
  session_write_close();
  header('Location: index.php');
  die();
}

} else{
echo"<p class='alert alert-danger'>User does not exists!</p>";
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
  <form method="post">
    <label>Login</label>
    <input type="text" class="form-control" name="login"/>

    <label>Password</label>
    <input type="password" class="form-control" name="password"/>

    <input type="submit" value="Войти">

  </form>
</body>
</html>
