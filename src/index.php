<?php


// Dispatcher
if ($_SERVER['REQUEST_URI']=='/') 
    {    require_once 'home.php'; }
else if(isset ($_GET['url']) && count($_GET)==1) 
    { require_once 'single_annotation.php';}
else if(isset ($_GET['lurl']) && isset($_GET['rurl']) && count($_GET)==2) 
    {    require_once 'double_annotation.php';}
else 
    { require_once('error.php');}

?>