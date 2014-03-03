<?php

require_once "easyrdf-0.8.0/lib/EasyRdf.php";


class Scraper {

    private $url;
    public $type;
    private $resolvedUrl;
    private $urlType;
    private $label;
    private $comment;
    private $format;
    private $annotableVersionAt;
    private $aggregatedCHO;
    private $domain;
    private $punditContent;
    private $bookMetadata;
    private $pageMetadata;
    private $prev = false;
    private $next = false;
    private $dm2ePrev = false;
    private $dm2eNext = false;
    private $stylesheet = false;
    private $dm2eGraph;
    private $pages;
    private $author;
    private $object;
    private $dataprovider;
    private $tableOfContents;
    private $pageLabel;
    private $date;

    /**
     * Public contructor set URL to be scraped
     * TODO: verify if the url is valid
     * TODO: Test
     * @param type $url 
     */
    public function __construct($url, $urlType=NULL) {
        $this->url = $url;
        $this->resolvedUrl = $this->getFinalUrl($url);

        if (!$this->isUrlValid())
            throw new Exception('Url is not VALID');
        $this->setUrlType($urlType);
        $this->retrievePunditContent();

    }

    public function getFinalUrl($url) {
        $furl = false;
        // First check response headers
        $headers = get_headers($url);
        // Test for 301, 302 or 303
        if(preg_match('/^HTTP\/\d\.\d\s+(301|302|303)/',$headers[0])) {
            foreach($headers as $value) {
                if(substr(strtolower($value), 0, 9) == "location:") {
                    $furl = trim(substr($value, 9, strlen($value)));
                }
            }
        }
        // Set final URL
        $furl = ($furl) ? $furl : $url;
        return $furl;
    }

    private function setUrlType($urlType) {
        $allowed_types = array ('default', 'img', 'dm2e');
        if($urlType==null) $this->urlType = 'default';
        else if (in_array($urlType, $allowed_types))
            $this->urlType=$urlType;
        else throw new Exception('Url Type '.$urlType.' Not allowed');
    }
    
    public function getPunditContent() {
        return $this->punditContent;
    }

    public function getBookMetadata() {
        return $this->bookMetadata;
    }
    
    public function getPageMetadata() {
        return $this->pageMetadata;
    }
    
    public function getContent() {
        if ($this->getBookMetadata() != '' && $this->getBookMetadata() != null) {
            return '<div class="left-menu-content">' . $this->getBookMetadata() .'</div>'.
                '<div class="page-content">' . $this->getPunditContent() . '</div>'.
                '<div class="right-content-details">' . $this->getPageMetadata() . '</div>';
        } else {
            return $this->getPunditContent();
        }
    }

    public function getLabel() {
        return $this->bookLabel;
    }
    
    public function getLinkToDM2EPage($page) {
        $s = $_SERVER['HTTP_HOST'];
        return 'http://'. $s .'/?dm2e='. $page .'&conf='. $_REQUEST['conf'];
    }
        
    public function getNext($pos = null) {
        $s = $_SERVER['HTTP_HOST'];
        
        if (!$this->next && !$this->dm2eNext)
            return false;
        
        // Single page annotation
        if (isset($_REQUEST['dm2e'])) {
            return 'http://'. $s .'/?dm2e='. $this->dm2eNext .'&conf='. $_REQUEST['conf'];
        } else if (!isset($_REQUEST['lurl']) && !isset($_REQUEST['rurl'])) {
            return 'http://'. $s .'/?url='. $this->next .'&conf='. $_REQUEST['conf'];

        } else if ($pos == "left") {
            return 'http://'. $s .'/?lurl='. $this->next .'&rurl='. $_REQUEST['rurl'] .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "right") {
            return 'http://'. $s .'/?rurl='. $this->next .'&lurl='. $_REQUEST['lurl'] .'&conf='. $_REQUEST['conf'];
        }
    }
    
    public function getPrev($pos = null) {
        $s = $_SERVER['HTTP_HOST'];
        
        if (!$this->prev && !$this->dm2ePrev)
            return false;
        
        // Single page annotation
        if (isset($_REQUEST['dm2e'])) {
            return 'http://'. $s .'/?dm2e='. $this->dm2ePrev .'&conf='. $_REQUEST['conf'];
        } else if (!isset($_REQUEST['lurl']) && !isset($_REQUEST['rurl'])) {
            return 'http://'. $s .'/?url='. $this->prev .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "left") {
            return 'http://'. $s .'/?lurl='. $this->prev .'&rurl='. $_REQUEST['rurl'] .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "right") {
            return 'http://'. $s .'/?rurl='. $this->prev .'&lurl='. $_REQUEST['lurl'] .'&conf='. $_REQUEST['conf'];
        }
    }
    
    public function getBookLink() {
        if (isset($this->book) && count($this->book)>0) {
            return $this->getLinkToDM2EPage($this->book);
        } else {
            return null;
        }
    }
    
    public function getStylesheet() {
        return $this->stylesheet;
    }
    
    public function getComment() {
        return $this->comment;
    }
    public function getAnnotableVersionAt() {
        return $this->annotableVersionAt;
    }
    public function getDomain() {
        return $this->domain;
    }


    private function doCurlRequest($contentType, $requestUrl='') {

        if ($requestUrl == '')
            $requestUrl = $this->url;

        $requestUrl = $this->getFinalUrl($requestUrl);

        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $requestUrl);

        // TODO: shouldnt it be "Accept" instead of "Content-type" ??!
        curl_setopt($request, CURLOPT_HTTPHEADER, array("X-Forwarded-For: " . $_SERVER['REMOTE_ADDR'] . ', ' . $_SERVER['SERVER_ADDR']));
        curl_setopt($request, CURLOPT_HTTPHEADER, array("Accept: {$contentType}"));
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($request);
        $error = curl_error($request);
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

        if (!curl_errno($request)) {
            $result = $response;
        } else {
            $result = $error;
        }

        curl_close($request);

        return $result;
    }

    /**
     * Retrieve pundit content through the content neg
     * // TODO: ALL!!!!!
     */
    private function retrievePunditContent() {
        switch ($this->urlType) {
            case 'default':
                $this->retrievePunditContentDefault();
                break;
            case 'img':
                $this->retrievePunditContentImg();
                break;
            case 'dm2e':
                $this->retrievePunditContentDm2e();
                break;
            default:
                throw new Exception('Url type '.$this->urlType.' not supported.');
                break;
        }
    }

    private function retrievePunditContentDm2e() {
        
        $this->url = str_replace('+','%2B',$this->url);
        
        $url = $this->url;

        $this->dm2eGraph = EasyRdf_Graph::newAndLoad($url);

        EasyRdf_Namespace::set('edm','http://www.europeana.eu/schemas/edm/');
        EasyRdf_Namespace::set('dm2e','http://onto.dm2e.eu/schemas/dm2e/');
        EasyRdf_Namespace::set('spar','http://purl.org/spar/pro/');
        EasyRdf_Namespace::set('skos','http://www.w3.org/2004/02/skos/core#');
        $this->nsDc = EasyRdf_Namespace::prefixOfUri('http://purl.org/dc/elements/1.1/');
        $this->nsDct = EasyRdf_Namespace::prefixOfUri('http://purl.org/dc/terms/');

        
        $types = $this->dm2eGraph->allResources($url, $this->nsDc . ':type');
        foreach ($types as $type) {
            if ($type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/1.1/Page' || $type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/Page' || $type->getUri()=='http://purl.org/spar/fabio/#Page') {
                $this->type = 'Page';
            } else if ($type->getUri()=='http://purl.org/ontology/bibo/Book' || $type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/Manuscript') {
                $this->type = 'Book';
            }
        }

        // Get the aggregation object...
        $agg = $this->getEDMAggregationOf($this->url);
        $this->aggregatedCHO = $agg;
        
        $this->annotableVersionAt = $this->aggregatedCHO->get('dm2e:hasAnnotatableVersionAt');

        if ($this->annotableVersionAt) {
            $this->format = $this->annotableVersionAt->get($this->nsDc . ':format');
            
            if (!$this->format) {
                $this->format = $this->aggregatedCHO->get($this->nsDc . ':format');
            }
        }

        // Properties of Books
        if ($this->type=='Page') {
            $this->dm2eNext = $this->getDm2eNextInSequence();
            $this->dm2ePrev = $this->getDm2ePrevInSequence();
            $this->book = $this->dm2eGraph->getResource($this->url, $this->nsDct . ':isPartOf');
            $this->dm2eGraph->load($this->book);
        } else if ($this->type == 'Book') {
            $this->book = $this->dm2eGraph->resource($this->url);
        }
        
        
        $this->bookLabel = $this->dm2eGraph->get($this->book->getUri(), $this->nsDc . ':title');
        
        $this->comment =  $this->dm2eGraph->get($this->book->getUri(), $this->nsDc . ':description');

        $this->pages = $this->getDm2ePages();
        
        $this->author = $this->getDm2eAuthors($this->book->getUri());
        
        $this->object = $this->aggregatedCHO->getResource('edm:object');
        
        $this->tableOfContents=$this->getDm2eTOC($this->book->getUri());
        
        $this->dataprovider = $this->getDM2eDataProvider($this->book->getUri());
        
        $this->hasMet = $this->dm2eGraph->all($url,'edm:hasMet');
        
        $this->date = $this->getDm2eDate($this->book->getUri());

        // Properties of the Page
        
        $this->pageLabel = $this->dm2eGraph->get($this->url, $this->nsDc . ':description');
        
        
        
        // TODO: get the type of the resource from the RDF, and not with a string match!
        if (isset($this->annotableVersionAt)){
            if (($this->format == "image/jpeg" || $this->format == "http://onto.dm2e.eu/schemas/dm2e/1.1/mime-types/image/jpeg")) {
                $this->punditContent .= '
                   <div class="pundit-content" about="' . $this->url .'">
                     <div class="pundit-content" about="'. $this->annotableVersionAt . '">
                       <img src="' . $this->annotableVersionAt . '" class="annotable-image" />
                     </div>
                   </div>
                 ';
            } else if ($this->format == "text/html") {

                // We assume that there is only html and body element and only one pundit content
                $content = $this->doCurlRequest('text/html', $this->annotableVersionAt);
                $content = preg_replace('@<body>@', '', $content);
                $content = preg_replace('@</body>@', '', $content);
                $content = preg_replace('@<html>@', '', $content);
                $content = preg_replace('@</html>@', '', $content);
                
                $this->punditContent .= '
                   <div class="pundit-content" about="' . $this->url .'">
                     <div class="pundit-content" about="'. $this->annotableVersionAt . '">'
                       . "Pippo" .
                     '</div>
                   </div>
                 ';
            }
            
        } else {
            $this->punditContent .= '
                <div class="pundit-content" about="' . $this->url .'">
                     <div class="pundit-content" about="'.$this->object.'">';
            $this->punditContent .= '<img src="'.$this->object.'"  />';
            $this->punditContent .= '</div></div>';
            
        }
        
        
            
            if (isset($this->bookLabel) && $this->bookLabel != null) {
                $this->bookMetadata .= '<h2>' . $this->bookLabel . '</h2><hr/>';
            }
            if (isset($this->author) && $this->author != null) {
                $this->bookMetadata .= '<strong>Author(s): </strong><br/>' . $this->author . '<hr/>';
            }
            if (isset($this->date) && $this->date != null) {
                $this->bookMetadata .= '<strong>Issued: </strong><br/>' . $this->date . '<hr/>';
            }
            if (isset($this->dataprovider) && $this->dataprovider != null) {
                $this->bookMetadata .= '<p><strong>Data provider:</strong><br/>' .
                                      $this->dataprovider . '</p><hr/>';    
            }
            if (isset($this->pages) && $this->pages != null) {
                $this->bookMetadata .= '<div><p><strong>Browse pages</strong></p>';
                $this->bookMetadata .= '<form action="http://' . $_SERVER['HTTP_HOST'] . '" method="get">';
                $this->bookMetadata .= '<select name="dm2e">';
                foreach ($this->pages as $page) {                    
                    $pageNumber = substr( $page, strrpos( $page, '/' ) +1 );
                    $this->bookMetadata .= '<option value="' . $page . '">' . $pageNumber . '</option>';
                }
                $this->bookMetadata .= '</select>';    
                $this->bookMetadata .= '<input type="hidden" name="conf" value="' . $_REQUEST['conf'] . '" />';    
                $this->bookMetadata .= '<div><input type="submit" value="Go to page" /></div>';
            
                $this->bookMetadata .= '</form>';    
                $this->bookMetadata .= '</div>';   
            }
            if (isset($this->hasMet) && $this->hasMet != null) {
                $this->bookMetadata .= '<strong>Related persons:</strong><hr/>';
                foreach ($this->hasMet as $met) {
                    $this->bookMetadata .= $this->getPersonDetails($met);    
                }
                
            }
            if ($this->tableOfContents != null) {
                $this->bookMetadata .= '<h4>Table of Contents</h4><p>' . $this->tableOfContents . '</p><hr/>';    
            }
            
        
        if ($this->type=="Page") {
            
            if (isset($this->bookLabel) && $this->bookLabel != null) {
                $this->pageMetadata .= '<p><h3>This page:</h3><br/><strong>Title: </strong>' . $this->pageLabel . '</p><hr/>';
            }
            
        }

    }
    
    private function getPersonDetails($url) {
        $this->dm2eGraph->load($url);
        $label = $this->dm2eGraph->get($url, 'skos:prefLabel');
        return '<strong>' . $label . '</strong>'.
               '<>';
    }
    
    private function retrievePunditContentDefault() {
        $rdf = $this->doCurlRequest('application/rdf+xml');
        $dom = new DOMDocument();
        $dom->loadXML($rdf);

        $this->bookLabel = $this->extractLabelByDom($dom);
        $this->next = $this->extractNextResourceByDom($dom);
        $this->prev = $this->extractPrevResourceByDom($dom);
        $this->stylesheet = $this->extractStylesheetByDom($dom);

        $this->comment = $this->extractCommentByDom($dom);
        $this->annotableVersionAt = $this->extractAnnotableVersionByDom($dom);        
        
        $url_info = parse_url($this->annotableVersionAt);
        $this->domain=$url_info['host'];
        // We assume that there is only html and body element and only one pundit content
        $content = $this->doCurlRequest('text/html', $this->annotableVersionAt);
        $content = preg_replace('@<body>@', '', $content);
        $content = preg_replace('@</body>@', '', $content);
        $content = preg_replace('@<html>@', '', $content);
        $content = preg_replace('@</html>@', '', $content);
        $this->punditContent = $content;
    }

    private function retrievePunditContentImg() {
        $this->bookLabel = 'Web image : '.$this->url;
        $this->comment = 'Single image pundit annotator';
        $url_info = parse_url($this->url);
        $this->domain = $url_info['host'];
        $this->punditContent = '
           <div class="pundit-content" about="'.$this->url.'">
           <img src="'.$this->url.'" />
           </div>
         ';
    }

    // TODO: use namespace rdfs::label
    private function extractLabelByDom(DOMDocument $dom) {
        return $this->extractTagValueByDom($dom, 'label');
    }

    
    private function extractCommentByDom(DOMDocument $dom) {
        return $this->extractTagValueByDom($dom, 'comment');
    }
        


    //DM2E functions

    private function getEDMAggregationOf($url) {
        
        $aggs = $this->dm2eGraph->resourcesMatching('edm:aggregatedCHO');
        foreach ($aggs as $agg) {
            $cho = $agg->getResource('edm:aggregatedCHO');
//            echo str_replace('+','%2B',$cho->getUri());
//            echo str_replace('+','%2B',$url);
            if ($cho->getUri() == $url) {
                return $agg;
            }
        }
        return null;
    }

    //Hack. Easy RDF library does not suppot a simple way to get triples specifying the object...
    private function getDm2eNextInSequence() {
        $next = false;
        $nexts = $this->dm2eGraph->resourcesMatching('edm:isNextInSequence');

        foreach ($nexts as $n) {
            if ($n != $this->url) {
                $next = $n;
                break;
            }
        }
        return $next;
    }
    
    private function getDm2ePrevInSequence() {
        return $this->dm2eGraph->get($this->url, 'edm:isNextInSequence');
    }

    // returns an array of Pages connected to the CHO via the dcterms:isPartOf relation
    private function getDm2ePages() {
        $parts = $this->dm2eGraph->resourcesMatching($this->nsDct . ':isPartOf');
        $pages = array();
        foreach ($parts as $part) {
            if ($part != $this->url) {
                        array_push($pages, $part);
            }
        }
        sort($pages);
        return $pages;
    }
    

    private function getDm2eAuthors($url) {
        $result = '';
        $cont = 0; 
        $authors = $this->dm2eGraph->allResources($url, 'spar:author');
        foreach ($authors as $auth) {
            $this->dm2eGraph->load($auth);     
            $authorLabel = $this->dm2eGraph->get($auth, 'skos:prefLabel');     
            $result .= $authorLabel;
            $cont++;
            if ($cont < count($authors)) { $result .= ',<br/>';}
     
        }
        return $result;
    }
    
    private function getDm2eDataProvider($url) {
        $aggregatedCHO = $this->getEDMAggregationOf($url);
        $provider = $aggregatedCHO->getResource('edm:dataProvider');
        $this->dm2eGraph->load($provider);
        $label = $this->dm2eGraph->get($provider,'skos:prefLabel');
        return $label;
    }
    
    private function getDm2eDate($url) {
        $issued = $this->dm2eGraph->getResource($url,$this->nsDct . ":issued");
        if ($issued != null) {
            $this->dm2eGraph->load($issued);
            $date = $this->dm2eGraph->get($issued, 'skos:prefLabel');    
        }
        return $date;
    }

    private function getDm2eTOC($url) {
        $toc = $this->dm2eGraph->get($url, $this->nsDct . ':tableOfContents');
        return str_replace('; ','<br></br>',str_replace(' | ','<br></br>',$toc));
        //return $toc;
    }

    
    private function extractAnnotableVersionByDom(DOMDocument $dom) {
        return $this->extractAttributeValueByDom($dom, 'hasAnnotableVersionAt', 'rdf:resource');
    }
    private function extractNextResourceByDom(DOMDocument $dom) {
        return $this->extractAttributeValueByDom($dom, 'nextResource', 'rdf:resource');
    }
    private function extractPrevResourceByDom(DOMDocument $dom) {
        return $this->extractAttributeValueByDom($dom, 'prevResource', 'rdf:resource');
    }
    private function extractStylesheetByDom(DOMDocument $dom) {
        return $this->extractAttributeValueByDom($dom, 'hasStyleSheet', 'rdf:resource');
    }
    
    private function extractTagValueByDom(DOMDocument $dom, $tagname) {
        $values = $dom->getElementsByTagName($tagname);
        $val='';
        foreach ($values as $value){
           $val = $value->nodeValue;
        }
        return $val;
    }

    private function extractAttributeValueByDom(DOMDocument $dom, $tagname, $attributename) {
        $val = false;
        
        $values = $dom->getElementsByTagName($tagname);
        foreach ($values as $value){
           $val = $value->getAttribute($attributename);
        }
        return $val;
    }
    
    /**
     * Verify if a URL is VALID
     * TODO: Test
     */
    private function isUrlValid() {
        return true;
        //return filter_var($this->url, FILTER_VALIDATE_URL);
    }

    public function getUrl() {
        return $this->url;
    }

}