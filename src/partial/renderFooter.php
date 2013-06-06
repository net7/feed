<?php
// Load the onload.js only if needed. It is not needed in the / page
function renderFooter($onload=true) {
?>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
<?php 
    if ($onload) {
?>
        <script src="/js/onload.js"></script>
<?php
    }
}