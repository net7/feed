
<?php

require_once "easyrdf-0.8.0/lib/EasyRdf.php";


try {
    $callback = $_GET["jsonp"];

    $url = $_GET["url"];;
    $rdfGraph = EasyRdf_Graph::newAndLoad($url);

    EasyRdf_Namespace::set('edm','http://www.europeana.eu/schemas/edm/');
    EasyRdf_Namespace::set('dm2e','http://onto.dm2e.eu/schemas/dm2e/');
    EasyRdf_Namespace::set('spar','http://purl.org/spar/pro/');
    EasyRdf_Namespace::set('owl','http://www.w3.org/2002/07/owl#');
    EasyRdf_Namespace::set('dbpedia','http://dbpedia.org/ontology/');
    EasyRdf_Namespace::set('rdfs','http://www.w3.org/2000/01/rdf-schema#');
    EasyRdf_Namespace::set('foaf','http://xmlns.com/foaf/0.1/');
    EasyRdf_Namespace::set('gndo','http://d-nb.info/standards/elementset/gnd#');

    EasyRdf_Namespace::set('skos','http://www.w3.org/2004/02/skos/core#');
    EasyRdf_Namespace::set('rdf','http://www.w3.org/1999/02/22-rdf-syntax-ns#');
    $nsDc = EasyRdf_Namespace::prefixOfUri('http://purl.org/dc/elements/1.1/');
    $nsDct = EasyRdf_Namespace::prefixOfUri('http://purl.org/dc/terms/');
    
    $type = $rdfGraph->getResource($url,'rdf:type');
    $dctype = $rdfGraph->getResource($url, $nsDc . ':type');
    
    $label = '';
    $description = '';
    $picture = '';

    if ($type == 'http://xmlns.com/foaf/0.1/Person') {
        $label = $rdfGraph->get($url,'skos:prefLabel');
        $sameas = $rdfGraph->getResource($url,'owl:sameAs');   
        if ($sameas) {
            $rdfGraph->load($sameas);
            $bio = $rdfGraph->get($sameas, 'gndo:biographicalOrHistoricalInformation');
            $sameases = $rdfGraph->allResources($sameas,'owl:sameAs');
            foreach ($sameases as $sa) {
                    $rdfGraph->load($sa);
                    $picture = $rdfGraph->getResource($sa,'foaf:depiction');
                    $pedia = $rdfGraph->get($sa,'rdfs:comment','literal','en');
                    if (!$pedia) {
                        $pedia = $rdfGraph->get($sa,'dbpedia:abstract','literal','en');
                    }
                    break;        
            }
    
            if ($bio) {
                $description .= '<b>Bio:</b><br/>' . $bio;
            }
            if ($pedia)
                $description .= '<br/><b>From DBpedia:</b><br/>' . $pedia;
        } 
    } else if ($type == 'http://www.europeana.eu/schemas/edm/ProvidedCHO' || $dctype == 'http://onto.dm2e.eu/schemas/dm2e/Page') {
        $label = $rdfGraph->get($url, $nsDc . ':title');
        $description = $rdfGraph->get($url, $nsDc . ':description');
        if ($type =='' || $type == null) {
            $type = $dctype;
        }
        $agg = $rdfGraph->resourcesMatching('edm:aggregatedCHO');
        if ($agg != null && count($agg)>0) {
            $versions = $agg[0]->allResources('dm2e:hasAnnotatableVersionAt');
            foreach($versions as $version) {
                if ($version) {
                    $format = $version->get($nsDc . ':format');
                    if ($format == 'image/jpeg') {
                        $picture = $version;
                        //We take the first picture only ...
                        break;
                    }
                }    
            }
            
            
        }
    }
    
    
    
    echo $callback . '({
        "@id": "http://data.dm2e.eu/data/agent/onb/authority_gnd/10093630X",
        "@type": "' . $type . '",
        "http://www.w3.org/2000/01/rdf-schema#label": "' . $label . '",
        "http://purl.org/dc/elements/1.1/description": "' . $description . '",
        "http://xmlns.com/foaf/0.1/depiction": "' . $picture . '"
    })';    
} catch (Exception $e) {
    
}
 


?>