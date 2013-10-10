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
        <?php if ($css1 = $rs->getStylesheet()) { ?>
            <link rel="stylesheet" href="<?php echo $css1; ?>" type="text/css">
        <?php } ?>
        <?php if (($css2 = $ls->getStylesheet()) && $css1 != $css2) { ?>
            <link rel="stylesheet" href="<?php echo $css2; ?>" type="text/css">
        <?php } ?>

        <link rel="stylesheet" href="css/feed.css" type="text/css">

    </head>
    <body class="clearfix">
        
        <div class="feed-space pundit-disable-annotation">&nbsp;</div>
        <div class="left-content">
            <?php renderPunditContent($ls, "left") ; ?>
        </div>
        <div class="right-content">
            <?php renderPunditContent($rs, "right") ; ?>
        </div>
        
        <?php renderFooter(); ?>
    </body>
</html>
