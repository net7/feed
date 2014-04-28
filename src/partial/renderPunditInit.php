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
        
        <link rel="stylesheet" href="services/ee/css/6a53cf14.main.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <script src="services/ee/scripts/10c165ed.libs.js" type="text/javascript" charset="utf-8"></script>
        <script src="services/ee/scripts/45fffb9b.korbo-ee.js" type="text/javascript" charset="utf-8"></script>
        
    <?php
}
?>
