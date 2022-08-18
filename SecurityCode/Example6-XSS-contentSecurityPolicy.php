<?php
  header("Content-Security-Policy: script-src 'self' https://apis.google.com; child-src https://youtube.com; img-src *");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XSS - Linking to trusted sources</title>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <script type="text/javascript" src="https://evil.com/malicious.js"></script>
</head>
<body>
  <h2>
    Hello, let's work with linking.
  </h2>
  <img src="http://www.loonycorn.com/resources/loonycorn-logo.png"/>
</body>
</html>
