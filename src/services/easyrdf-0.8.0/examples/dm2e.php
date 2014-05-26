<?php
    /**
     * Basic "Hello World" type example
     *
     * A new EasyRdf_Graph object is created and then the contents
     * of my FOAF profile is loaded from the web. An EasyRdf_Resource for
     * the primary topic of the document (me, Nicholas Humfrey) is returned
     * and then used to display my name.
     *
     * @package    EasyRdf
     * @copyright  Copyright (c) 2009-2013 Nicholas J Humfrey
     * @license    http://unlicense.org/
     */

    set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
    require_once "EasyRdf.php";
?>
<html>
<head>
  <title>Basic FOAF example</title>
</head>
<body>

<?php
  
  
    $url = 'http://data.dm2e.eu/data/item/bbaw/dta/16168';
 // $url =  'http://data.dm2e.eu/data/item/mpiwg/harriot/MPIWG:0HE26A22';
  
  $dm2e = EasyRdf_Graph::newAndLoad($url);
  
 
  EasyRdf_Namespace::set('dm2e11','http://onto.dm2e.eu/schemas/dm2e/1.1/'); 
  EasyRdf_Namespace::set('edm','http://www.europeana.eu/schemas/edm/');
  EasyRdf_Namespace::set('dm2e','http://onto.dm2e.eu/schemas/dm2e/1.1/');
  EasyRdf_Namespace::set('dct','http://purl.org/dc/terms/');
  EasyRdf_Namespace::set('dc','http://purl.org/dc/elements/1.1/');
  EasyRdf_Namespace::set('spar','http://purl.org/spar/pro/');
  EasyRdf_Namespace::set('skos','http://www.w3.org/2004/02/skos/core#');
  
  //$nsDc = EasyRdf_Namespace::prefixOfUri('http://purl.org/dc/elements/1.1/');
  $nsSpar = EasyRdf_Namespace::prefixOfUri('http://purl.org/spar/pro/');
  


  //$nexts = $dm2e->resourcesMatching($nsDct . ':isPartOf');
  //foreach ($nexts as $next) {
 //     if ($next!=$url) {
 //         echo "Page: $next<br />\n";          
 //     }
 // }
  
 //$aggs = $dm2e->resourcesMatching('edm:aggregatedCHO');
 //echo $aggs[0]->getResource('edm:dataProvider');
 


 //GET Author
 
 $authors = $dm2e->allResources($url, 'spar:author');
 
 foreach ($authors as $auth) {
     $dm2e->load($auth);     
     
     $authorLabel = $dm2e->get($auth, 'skos:prefLabel');

     echo "Author:  " . $authorLabel . '<br/>';
     
 }
 

 
 
 // Get subtitle

 $subtitle = $dm2e->get($url, 'dm2e11:subtitle');
 
 echo 'Subtitle: ' . $subtitle . '<br/>';
 
 // Get printed at
 
 $printedAt = $dm2e->get($url, 'dm2e11:printedAt');
 
 $dm2e->load($printedAt);
 
 $placeLabel = $dm2e->get($printedAt, 'skos:prefLabel'); 
 
  echo 'Printed at: ' . $placeLabel . '<br/>';

 


  
  
  

?>


</body>
</html>
