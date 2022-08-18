<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Sanitizing input</title>
</head>
<body>
<form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First name:<br>
    <input type="text" name="firstname"><br>
    Last name:<br>
    <input type="text" name="lastname"><br>
    Email:<br>
    <input type="text" name="email"><br>
    Phone number:<br>
    <input type="text" name="phone"><br>

    <br>
    Property Type:<br>
    <input type="radio" name="propertytype" value="condo" checked>Condomimium<br>
    <input type="radio" name="propertytype" value="townhome">Townhome<br>
    <input type="radio" name="propertytype" value="house">House<br>

    <br>
    <input type="submit" value="Submit">
</form>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<h2> Thank you for submitting your request! </h2>';

    $fullname = clean($_POST['firstname']) . " " . clean($_POST['lastname']);
    $contact = clean($_POST['email']) . ", " . clean($_POST['phone']);

    echo 'Here are your form details: <br><br>';
    echo "<b>Name</b>: " . $fullname . "<br>";
    echo "<b>Contact details</b>: " . $contact . "<br>";
    echo "Looking to buy a " . clean($_POST['propertytype']) . "<br>";
  }

  function clean($input) {
    // Trims whitespace from input
    $input = trim($input);
    // Removes slashes from input data
    $input = stripslashes($input);

    // Typically you would use either strip_tags or htmlspecialchars
    // depending on whether you want to remove the HTML characters
    // or just neutralize it.

    // Removes all the html tags from input data
    $input = strip_tags($input);
    // Escapes html characters from input data
    $input = htmlspecialchars($input);

    return $input;
  }
?>

</body>
</html>
