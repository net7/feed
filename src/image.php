<!doctype html>
<html>
<head>

    <meta charset="UTF-8">

    <link rel="stylesheet" href="http://dev.thepund.it/download/client/last-beta/pundit2.css" type="text/css">
    <script src="http://dev.thepund.it/download/client/last-beta/libs.js" type="text/javascript" ></script>
    <script src="http://dev.thepund.it/download/client/last-beta/pundit2.js" type="text/javascript" ></script>

    <?php if(isset($_GET['conf'])): ?>

        <script src="<?php echo $_GET['conf'] ?>" type="text/javascript" ></script>

    <?php else: ?>

        <script src="http://dev.thepund.it/download/client/last-beta/pundit2_conf.js" type="text/javascript" ></script>

    <?php endif; ?>
</head>
<body>
<div data-ng-app="Pundit2" ></div>
<img src="<?php echo $_GET['i'] ?>" />
</body>
</html>
