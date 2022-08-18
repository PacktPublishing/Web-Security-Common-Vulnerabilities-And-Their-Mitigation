<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection - Your trusted bank site</title>
</head>
<body style="font-family: sans-serif;">

<?php
  function getDatabaseConnection() {
    $servername = "localhost";
    $username = "janani";
    $password = "password";
    $dbName = "booDB";

    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Comment out if the table does not exist.
    //$drop_query = "DROP TABLE BankAccounts";
    if ($conn->query($drop_query) !== TRUE) {
        echo "Error dropping table: " . $conn->error;
    }

    $create_query = <<<_CREATE_
        CREATE TABLE IF NOT EXISTS BankAccounts (
          account_id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          user_name VARCHAR(100) NOT NULL,
          account_balance INT(100) NOT NULL
        )
_CREATE_;

    $result = $conn->query($create_query);
    if($result === FALSE) {
        die("Create failed: " . mysql_error());
    }

  $insert_queries = array();
  $insert_queries[] = <<<_INSERT_
      INSERT INTO BankAccounts
      VALUES
        (1234, 'Janani', 12345)
_INSERT_;
  $insert_queries[] = <<<_INSERT_
      INSERT INTO BankAccounts
      VALUES
        (1111, 'Pradeep', 100953)
_INSERT_;
  $insert_queries[] = <<<_INSERT_
      INSERT INTO BankAccounts
      VALUES
        (2222, 'Vitthal', 997)
_INSERT_;

    foreach ($insert_queries as $query) {
      if ($conn->query($query)) {
          //echo "Inserted row: $query\n";
      } else {
          echo "Error inserting row: " . mysqli_error($conn) . "\n";
      }
    }
    return $conn;
  }

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  $account_id = $_GET['account_id'];

  if (!empty($account_id)) {
    try {
      $conn = getDatabaseConnection();
      $query = "SELECT * FROM BankAccounts WHERE account_id = " . $account_id;
      echo "Query: " . $query;

      $result = $conn->query($query);

      if ($result->num_rows > 0) {
          echo '<br><br><table>';
          echo '<td style="width: 100px; height: 22px">' . "<b>Account id</b>" . '</td>';
          echo '<td style="width: 150px; height: 22px">' . "<b>User</b>" . '</td>';
          echo '<td style="width: 100px; height: 22px">' . "<b>Balance</b>" . '</td>';
          while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="width: 100px; height: 18px">' . $row['account_id'] . '</td>';
            echo '<td style="width: 150px; height: 18px">' . $row['user_name'] . '</td>';
            echo '<td style="width: 100px; height: 18px">' . $row['account_balance'] . '</td>';
            echo '</tr>';
          }
          echo '</table>';
      } else {
          echo "<br><br>No results match your search:-(";
      }


      $conn->close($conn);
    } catch (Exception $e) {
      echo 'Error! ' + $e->getCode();
    }
  }
?>

<h3> Account information page at your trusted bank</h3>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <br>
  <input type="text" name="account_id" value="1234" readonly>
  <br>
  <input type="submit" value="Account details">
</form>
<br>
</body>
</html>
