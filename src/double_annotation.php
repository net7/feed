<?php
require_once(dirname(__FILE__).'/../lib/Scraper.class.php');
try {
$rs=new Scraper($_GET['rurl']);
}
 catch (Exception $e) {
     echo $e->getMessage();
     die();
 }
try {
$ls=new Scraper($_GET['lurl']);
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
        <div class="left-content">
            <?php renderPunditContent($ls) ; ?>
        </div>
        <div class="right-content">
            <?php renderPunditContent($rs) ; ?>
        </div>
        
        <?php renderFooter(); ?>
    </body>
</html>
