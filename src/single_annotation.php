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
        <?php if ($css = $s->getStylesheet()) { ?>
            <link rel="stylesheet" href="<?php echo $css; ?>" type="text/css">
        <?php } ?>
        
        <link rel="stylesheet" href="css/feed.css" type="text/css">
    </head>
    <body class="clearfix">
        <div class="feed-space pundit-disable-annotation">&nbsp;</div>
        <?php renderPunditContent($s) ; ?>
        <?php renderFooter(); ?>
    </body>
</html>
