<?php
try {
$s=new Scraper($_GET['url2'],'advanced');
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
        <?php renderPunditContent($s) ; ?>
    </body>
</html>
