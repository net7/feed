<?php
try {
$s=new Scraper($_GET['url']);
}
 catch (Exception $e) {
     echo $e->getMessage();
     die();
 }
 
?>
<!doctype html>
<html>
    <head>
        <?php renderHead(); ?>
        <link rel="stylesheet" href="css/feed.css" type="text/css">

    </head>
    <body class="clearfix">
        <div class="feed-space pundit-disable-annotation">&nbsp;</div>
        <?php renderPunditContent($s) ; ?>
        <?php renderFooter(); ?>
    </body>
</html>
