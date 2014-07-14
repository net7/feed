<?php

require_once(dirname(__FILE__).'/../lib/Scraper.class.php');
// Bookmarklet-like: we do not need any partial any more (only for pundit2)
if (isset($_GET['b'])) 
    {    require_once 'bookmarklet.php'; }
else  if (isset($_GET['fp'])){
    // it's a fusepool request
       require_once('fusepool.php');
} else {
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
else if(isset ($_GET['dm2e'])) 
    {    require_once 'dm2e_annotation.php';}
else if(isset ($_GET['url2'])) 
    {    require_once 'single_annotation_pundit2.php';}
else 
    { require_once('error.php');}

}
?>