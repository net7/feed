<?php
try {
$s=new Scraper($_GET['url2']);
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
        
        <?php if ($css = $s->getStylesheet()) { ?>
            <link rel="stylesheet" href="<?php echo $css; ?>" type="text/css">
        <?php } ?>
        
        <link rel="stylesheet" href="css/feed.css" type="text/css">        
        
        <link rel="stylesheet" href="pundit2/pundit2.css" type="text/css">        
        <script src="pundit2/libs.js" type="text/javascript" ></script>
        <script src="pundit2/pundit2.js" type="text/javascript" ></script>
        <script>var punditConfig = {
                modules: {
                    'Client': {
                        active: true
                    }
                }
            }</script>
        
    </head>
    <body data-ng-app="Pundit2" >
        <?php renderPunditContent($s) ; ?>
        <?php renderFooter(); ?>
    </body>
</html>
