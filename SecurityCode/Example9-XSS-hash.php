<?php
  header("Content-Security-Policy: script-src 'sha256-HTyd6tgUIWr6CMQgp61rqoacz3MZiOnNmMdnziO63HU='");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Hash</title>
</head>
<body>
  <script>
    window.onload = doSomething();
    function doSomething() {
      alert("This alert is inline with the hash");
    }
  </script>
</body>
</html>
