<?php
function renderPunditInit() {
    ?>
        <link rel="stylesheet" href="pundit/css/pundit.css" type="text/css">
        <script src="pundit/dojo/dojo/dojo.js.uncompressed.js" type="text/javascript"></script>
        <script src="pundit_conf/cortona.js" type="text/javascript"></script>
        <script>
           dojo.registerModulePath("pundit", "../../src"); 
           dojo.require('pundit.Init');
        </script>
    <?php
}
?>
