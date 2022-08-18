<?php
  $nonce = sha1(uniqid('n', true));
  header("Content-Security-Policy: script-src 'nonce-$nonce'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Nonce</title>
</head>
<body>
  <script nonce=<?php echo $nonce ?>>
    window.onload = doSomething();
    function doSomething() {
      alert("This alert is inline with the nonce");
    }
  </script>
</body>
</html>
