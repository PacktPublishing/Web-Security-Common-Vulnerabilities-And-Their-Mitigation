<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Start a discussion with your trusted site!</title>
</head>
<body style="font-family: sans-serif;">

<?php
  function getDatabaseConnection() {
    $servername = "localhost";
    $username = "janani";
    $password = "password";
    $dbName = "booDB";

    $conn = new mysqli($servername, $username, $password, $dbName);

    // Compatible with later PHP versions.
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $create_query = <<<_CREATE_
        CREATE TABLE IF NOT EXISTS Comments (
          user_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          user_name VARCHAR(100) NOT NULL,
          user_comment VARCHAR(250) NOT NULL
        )
_CREATE_;

    if ($conn->query($create_query) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }

    return $conn;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $user_name = $_POST['user_name'];
    $user_comment = $_POST['user_comment'];

    try {
      $conn = getDatabaseConnection();

      $stmt = $conn->prepare(
        "INSERT INTO `Comments` (user_name, user_comment) VALUES (?, ?)"
      );
      $stmt->bind_param("ss", $user_name, $user_comment);
      $stmt->execute();

      $stmt->close();
      $conn->close();

      echo 'Thank you for submitting your comment!';
    } catch (Exception $e) {
      echo 'Error! ' + $e->getCode();
    }
  }
?>

<h3> Do you have any comments?</h3>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Name:
  <br>
  <input type="text" name="user_name" maxlength="100">
  <br>
  <br>
  Comment:
  <br>
  <input type="text" name="user_comment"
      maxlength="250" size="60">
  <br>
  <br>
  <input type="submit" value="Comment">
</form>
<br>
</body>
</html>
