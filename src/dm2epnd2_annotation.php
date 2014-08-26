<?php
try {
    $s = new Scraper($_GET['dm2epnd2'], 'dm2e');
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
 
?>
<!doctype html>
<html>
    <head>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<?php
  $conf="http://dev.thepund.it/download/client/last-beta/pundit2_conf.js";
    if(isset($_GET['conf'])) $conf=$_GET['conf'];
        
  $pndurl="http://dev.thepund.it/download/client/last-beta";
    if(isset($_GET['pndurl'])) $pndurl=$_GET['pndurl'];
        
  $punditCode = <<<EOF
    <link rel="stylesheet" href="$pndurl/pundit2.css" type="text/css">        
    <script src="$pndurl/libs.js" type="text/javascript" ></script>
    <script src="$pndurl/pundit2.js" type="text/javascript" ></script>
    <script src="$conf" type="text/javascript" ></script>                
EOF;

  echo $punditCode; 
?>

        <link rel="stylesheet" href="css/feed.css" type="text/css">

    </head>
    <body class="clearfix" data-ng-app="Pundit2">
        <div class="feed-space pundit-disable-annotation">&nbsp;</div>
        <?php renderPunditContent($s); ?>
    </body>
</html>
