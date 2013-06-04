<?php

require_once(dirname(__FILE__).'/../lib/Scraper.class.php');
require_once 'partial/renderPunditContent.php';
require_once 'partial/renderPunditInit.php';
require_once 'partial/renderHead.php';
require_once 'partial/renderFooter.php';

// Dispatcher
if ($_SERVER['REQUEST_URI']=='/') 
    {    require_once 'home.php'; }
else if(isset ($_GET['url'])) 
    { require_once 'single_annotation.php';}
else if(isset ($_GET['lurl']) && isset($_GET['rurl'])) 
    {    require_once 'double_annotation.php';}
else if(isset ($_GET['img'])) 
    {    require_once 'img_annotation.php';}
else 
    { require_once('error.php');}

?>