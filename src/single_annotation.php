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
    </head>
    <body>
        <div class="feed-space">&nbsp;</div>
        <?php renderPunditContent($s) ; ?>
        <?php renderFooter(); ?>
    </body>
</html>
