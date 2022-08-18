<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Display all comments</title>
</head>
<body style="font-family: sans-serif; font-size: 12px">
<h2> Here are all the comments on the trusted site! </h2>
<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  $servername = "localhost";
  $username = "janani";
  $password = "password";
  $dbName = "booDB";

  $conn = mysqli_connect($servername, $username, $password, $dbName) or
      die("Connection failed: " . mysqli_connect_error());

  $query = 'SELECT * from Comments';
  $result = mysqli_query($conn, $query);
  if($result === FALSE) {
      die(mysql_error());
  }

  if (mysqli_num_rows($result) > 0) {
      echo '<table>';
      echo '<td style="width: 100px; height: 22px">' . "<b>Username</b>" . '</td>';
      echo '<td style="width: 250px; height: 44px">' . "<b>Comment</b>" . '</td>';
      while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td style="width: 100px; height: 18px">' . $row['user_name'] . '</td>';
        echo '<td style="width: 150px; height: 18px">' . $row['user_comment'] . '</td>';
        echo '</tr>';
      }
      echo '</table>';
  } else {
      echo "<br><br>No results match your search:-(";
  }

  mysqli_close($conn);
?>

</body>
</html>
