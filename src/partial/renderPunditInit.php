<?php
function renderPunditInit() {
    $conf = 'cortona.js';
    if(isset ($_GET['conf'])) $conf = $_GET['conf'];
    ?>
        <link rel="stylesheet" href="pundit/css/pundit.css" type="text/css">
        <script src="pundit/dojo/dojo/dojo.js.uncompressed.js" type="text/javascript"></script>
        <script src="pundit_conf/<?php echo $conf ?>" type="text/javascript"></script>
        <script>
           dojo.registerModulePath("pundit", "../../src"); 
           dojo.require('pundit.Init');
        </script>
    <?php
}
?>
