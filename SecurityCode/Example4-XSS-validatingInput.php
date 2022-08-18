<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Validating input</title>
</head>
<body>
<?php
  $name = "";
  $name_error_msg = "";
  $email = "";
  $email_error_msg = "";
  $phone = "";
  $phone_error_msg = "";
  $property = "";s
  $property_error_msg = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name'])) {
      $name_error_msg = "Name is a required field";
    } else {
      $name = clean($_POST['name']);
      if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $name_error_msg = "Please use only letters and whitespaces";
      }
    }

    if (empty($_POST['email'])) {
      $email_error_msg = "Email address is a required field";
    } else {
      $email = clean($_POST['email']);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error_msg = "The email format is not valid";
      }
    }

    if (empty($_POST['phone'])) {
      $phone_error_msg = "Phone number is a required field";
    } else {
      $phone = clean($_POST['phone']);
      if (!filter_var($phone, FILTER_VALIDATE_INT)) {
        $phone_error_msg = "Please enter only a number with no spaces or special characters";
      }
    }

    if (empty($_POST['propertytype'])) {
      $property_error_msg = "Property type is a required field";
    } else {
      $property = clean($_POST['propertytype']);
    }

    if (empty($name_error_msg) && empty($email_error_msg) &&
        empty($phone_error_msg) && empty($property_error_msg)) {
      echo '<h3> Thank you for submitting your request! </h3>';
    }
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

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name:
    <span style="color: red">*<?php echo $name_error_msg;?></span>
    <br>
    <input type="text" name="name" value="<?php echo $name;?>">
    <br>
    <br>
    Email:
    <span style="color: red">*<?php echo $email_error_msg;?></span>
    <br>
    <input type="text" name="email" value="<?php echo $email;?>">
    <br>
    <br>
    Phone number:
    <span style="color: red">*<?php echo $phone_error_msg;?></span>
    <br>
    <input type="text" name="phone" value="<?php echo $phone;?>">
    <br>
    <br>
    Property Type:
    <span style="color: red">*<?php echo $property_error_msg;?></span>
    <br>
    <input type="radio" name="propertytype" value="condo" <?php if (isset($property) && $property=="condo") echo "checked";?>>Condomimium<br>
    <input type="radio" name="propertytype" value="townhome" <?php if (isset($property) && $property=="townhome") echo "checked";?>>Townhome<br>
    <input type="radio" name="propertytype" value="house" <?php if (isset($property) && $property=="house") echo "checked";?>>House<br>
    <br>
    <br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
