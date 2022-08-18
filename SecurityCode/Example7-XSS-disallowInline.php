<?php
  //header("Content-Security-Policy: script-src 'unsafe-inline'");
  header("Content-Security-Policy: script-src 'self'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Disallowing inline content</title>
    <script>
      function handleButtonClick() {
        alert("You inline clicked the button!");
      }
    </script>
</head>
<body>
  <button onclick="handleButtonClick()"> Click me! I execute an inline script </button>
  <br>
  <br>
  <button id="button-id"> Click me! I execute a script in a JS file </button>

  <script src='Example7-XSS-disallowInline.js'></script>
</body>
</html>
