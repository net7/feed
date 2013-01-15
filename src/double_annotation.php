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
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="css/feed.css" type="text/css">
        <link rel="stylesheet" href="pundit/css/pundit.css" type="text/css">
<script src="pundit/dojo/dojo/dojo.js.uncompressed.js" type="text/javascript"></script>
<script src="pundit_conf/cortona.js" type="text/javascript"></script>
<script>
    dojo.registerModulePath("pundit", "../../src"); 
    dojo.require('pundit.Init');
</script>
    </head>

    
  
    <body>
        
        <div class="feed-space">&nbsp;</div>
        
        <div class="left-content">
        <div class="feed-header">
            <span class="label"><?php echo $ls->getLabel() ?></span><br/>
            <span class="comment"><?php echo $ls->getComment() ?></span><br/>
            <span class="annotable-version-at"><?php echo $ls->getAnnotableVersionAt() ?></span><br/>
        </div>
        <div class="feed-container"> 
 <?php echo $ls->getPunditContent(); ?>
        </div>
        </div>

        
        <div class="right-content">
        <div class="feed-header">
            <span class="label"><?php echo $rs->getLabel() ?></span><br/>
            <span class="comment"><?php echo $rs->getComment() ?></span><br/>
            <span class="annotable-version-at"><?php echo $rs->getAnnotableVersionAt() ?></span><br/>
        </div>
        <div class="feed-container"> 
 <?php echo $rs->getPunditContent(); ?>
        </div>
        </div>

</body>
</html>
