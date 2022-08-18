<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signing up for the Top Secret Club</title>
</head>
<body style="font-family: sans-serif;">
<?php
  function validate_inputs($user_email, $user_password) {
    $error = "";

    if (!isset($user_email, $user_password)) {
      $error = 'Please enter a valid username and password';
    } elseif (strlen($user_password) < 8 || strlen($user_password) > 20) {
      $error = 'The password length should be between 8 and 20 characters';
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
      $error = 'The user name should be a valid email address';
    } elseif (!ctype_alnum($user_password)) {
      $error = 'The password should only have alphabets or numbers';
    }

    return $error;
  }

  function getDatabaseConnection() {
    $servername = "localhost";
    $username = "janani";
    $password = "password";
    $dbName = "booDB";

    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $create_query = <<<_CREATE_
        CREATE TABLE IF NOT EXISTS Users (
          user_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          user_email VARCHAR(100) NOT NULL,
          user_password VARCHAR(40) NOT NULL,
          UNIQUE KEY user_email(user_email)
        )
_CREATE_;

    if ($conn->query($create_query) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }

    return $conn;
  }

  $error_message = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = validate_inputs($_POST['user_email'], $_POST['user_password']);
    // If no errors then add the user to the database.
    if (empty($error_message)) {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $user_email = filter_var($_POST['user_email'], FILTER_SANITIZE_STRING);
      $user_password = filter_var($_POST['user_password'], FILTER_SANITIZE_STRING);

      try {
        $conn = getDatabaseConnection();

        $stmt = $conn->prepare(
          "INSERT INTO `Users` (user_email, user_password) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $user_email, sha1($user_password));
        $stmt->execute();

        $stmt->close();
        $conn->close();
      } catch (Exception $e) {
        // Duplicate entry for key is error 1062
        if($e->getCode() == 1062) {
          $error_message =
            'Username already exists, please sign in or choose a different user name';
        }
        else {
          $error_message =
            'We are unable to process your request. Please try again later';
        }
      }
    }
  }
?>

<h3> Sign up to our new Top Secret Club! </h3>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <span style="color: red"><?php echo $error_message;?></span>
  <br>
  <br>
  Email address:
  <br>
  <input type="text" name="user_email" maxlength="100">
  <br>
  <br>
  Password:
  <br>
  <input type="text" name="user_password" maxlength="20">
  <br>
  <br>
  <input type="submit" value="Sign up">

  <input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
</form>
<br>
<a href="Example11-CredentialMgmt-login.php"> Already a member? Login </a>

<?php
  $error_message = "";
?>
</body>
</html>
