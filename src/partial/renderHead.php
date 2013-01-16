<?php
function renderHead($renderPundit=1) {
?>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <?php if($renderPundit) renderPunditInit(); ?>
<?php    
}
