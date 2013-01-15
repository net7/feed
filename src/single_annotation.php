<?php
require_once(dirname(__FILE__).'/../lib/Scraper.class.php');
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
        <div class="feed-header">
            <span class="label"><?php echo $s->getLabel() ?></span><br/>
            <span class="comment"><?php echo $s->getComment() ?></span><br/>
            <span class="annotable-version-at"><?php echo $s->getAnnotableVersionAt() ?></span><br/>
        </div>
        <div class="feed-container"> 
 <?php echo $s->getPunditContent(); ?>
        </div>

</body>
</html>
