<?php

require_once "easyrdf-0.8.0/lib/EasyRdf.php";


class Scraper {

    protected $url;
    public $type;
    protected $resolvedUrl;
    protected $urlType;
    protected $label;
    protected $comment;
    protected $annotableVersionAt;
    protected $aggregatedCHO;
    protected $domain;
    protected $punditContent;
    protected $bookMetadata;
    protected $pageMetadata;
    protected $prev = false;
    protected $next = false;
    protected $dm2ePrev = false;
    protected $dm2eNext = false;
    protected $stylesheet = false;
    protected $dm2eGraph;
    protected $pages;
    protected $author;
    protected $object;
    protected $dataprovider;
    protected $tableOfContents;
    protected $pageLabel;
    protected $date;
    protected $shownBy;
    protected $pageShownBy;
    protected $subjetc;

    protected $showAllPages = false;
    

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
        $allowed_types = array ('default', 'advanced', 'img', 'dm2e','bookmarklet');
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
                '<div class="page-content">' . $this->getPunditContent() . '</div>';
//            '<div class="right-content-details">' . $this->getPageMetadata() . '</div>'
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
            return 'http://'. $s .'/?dm2e='. urlencode($this->dm2eNext) .'&conf='. $_REQUEST['conf'];
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
            return 'http://'. $s .'/?dm2e='. urlencode($this->dm2ePrev) .'&conf='. $_REQUEST['conf'];
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
        case 'advanced':
        $this->retrievePunditContentAdvanced();
        break;
        case 'img':
        $this->retrievePunditContentImg();
        break;
        case 'dm2e':
        $this->retrievePunditContentDm2e();
        break;
        case 'bookmarklet':
        $this->retrieveBookmarklet();
        break;
        default:
        throw new Exception('Url type '.$this->urlType.' not supported.');
        break;
      }
    }

    private function retrievePunditContentDm2e() {
        
        if (isset($_GET["pages"])) {
                $this->showAllPages = $_GET["pages"];
        }
        
        
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
            if ($type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/1.1/Page' || $type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/Page' || $type->getUri()=='http://purl.org/spar/fabio/#Page' || $type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/Paragraph') {
                $this->type = 'Page';
            } else if ($type->getUri()=='http://purl.org/spar/fabio/Article' || $type->getUri()=='http://purl.org/ontology/bibo/Issue' || $type->getUri()=='http://purl.org/spar/fabio/Article' || $type->getUri()=='http://purl.org/ontology/bibo/Book' || $type->getUri()=='http://purl.org/ontology/bibo/Journal' || $type->getUri()=='http://onto.dm2e.eu/schemas/dm2e/Manuscript' || $type->getUri()=='http://purl.org/ontology/bibo/Letter') {
                $this->type = 'Book';
            }
        }
        
        // Get the aggregation object...
        $agg = $this->getEDMAggregationOf($this->url);
        $this->aggregatedCHO = $agg;
        
        $this->annotableVersionAt = $this->aggregatedCHO->allResources('dm2e:hasAnnotatableVersionAt');


        // Properties of Books
        if ($this->type=='Page') {
            $this->dm2eNext = $this->getDm2eNextInSequence();
            $this->dm2ePrev = $this->getDm2ePrevInSequence();
            $this->book = $this->getDM2EparentCHO($this->url);
            $this->dm2eGraph->load($this->book);
        } else if ($this->type == 'Book') {
            $this->book = $this->dm2eGraph->resource($this->url);
        }
        
        
        $this->bookLabel = $this->dm2eGraph->get($this->book->getUri(), $this->nsDc . ':title');
        
        $this->comment =  $this->dm2eGraph->get($this->book->getUri(), $this->nsDc . ':description');

        $this->pages = $this->getDm2ePages($this->book->getUri());
        
        $this->author = $this->getDm2eResourceArray($this->book->getUri(),'spar:author',true);
        
        $this->object = $this->aggregatedCHO->getResource('edm:object');
        
        $this->tableOfContents=$this->getDm2eTOC($this->book->getUri());
        
        $this->dataprovider = $this->getDM2eDataProvider($this->book->getUri());
        
        $this->hasMet = $this->dm2eGraph->all($url,'edm:hasMet');
        
        $this->date = $this->getDm2eDate($this->book->getUri());

        $this->shownBy = $this->aggregatedCHO->getResource('edm:isShownBy');
        
        $this->subject = $this->getDM2EResourceArray($this->book, $this->nsDc . ':subject', false);

        // Properties of the Page
        
        $this->pageLabel = $this->dm2eGraph->get($this->url, $this->nsDc . ':description');
        
        $this->shownBy = $this->aggregatedCHO->getResource('edm:isShownBy');
        
        if (!$this->shownBy) {
            $this->shownBy = $this->aggregatedCHO->getResource('edm:isShownAt');
        }
        
        if ($this->showAllPages == 'true') {
            
            $this->showPagesPreview($this->pages);
            
            
        } else {
            
            $this->showSinglePage();
            
        }
        
        
        
        // Metadata Side bar ...
            
            if (isset($this->bookLabel) && $this->bookLabel != null) {
                $this->bookMetadata .= 'Title<h4>' . $this->bookLabel . '</h4><hr/>';
            }
            if (isset($this->author) && $this->author != null) {
                $this->bookMetadata .= '<strong>Author(s): </strong><br/>' . $this->author . '<hr/>';
            }
            if (isset($this->subject) && $this->subject != null) {
                $this->bookMetadata .= '<strong>Subject(s): </strong><br/>' . $this->subject . '<hr/>';
            }
            if (isset($this->date) && $this->date != null) {
                $this->bookMetadata .= '<strong>Issued: </strong><br/>' . $this->date . '<hr/>';
            }
            
            if (isset($this->pages) && $this->pages != null) {
                if ($this->showAllPages == 'true') {
                    $url1 ='';
                    if (!isset($_GET["pages"])) {
                        $url1 = $_SERVER['REQUEST_URI'] . '&pages=false';
                    } else if ($_GET["pages"] == 'true') {
                        $url1 = str_replace('pages=true','pages=false',$_SERVER['REQUEST_URI']);
                    } else if ($_GET["pages"] == 'false') {
                        $url1 = $_SERVER['REQUEST_URI'];
                    }
                    $this->bookMetadata .= '<div><a href="' . $url1 . '"><strong>Show cover page</a></p></div><hr/>';
                } else {
                    $url2 ='';
                    if (!isset($_GET["pages"])) {
                        $url2 = $_SERVER['REQUEST_URI'] . '&pages=true';
                    } else if ($_GET["pages"] == 'false') {
                        $url2 = str_replace('pages=false','pages=true',$_SERVER['REQUEST_URI']);
                    } else if ($_GET["pages"] == 'true') {
                        $url2 = $_SERVER['REQUEST_URI'];
                    }
                    $this->bookMetadata .= '<div><a href="' . $url2 . '"><strong>Show all pages</a></p></div><hr/>';        
                }
                
                $this->bookMetadata .= '<div><p><strong>Browse pages</strong></p>';
                $this->bookMetadata .= '<form action="http://' . $_SERVER['HTTP_HOST'] . '" method="get">';
                $this->bookMetadata .= '<select name="dm2e">';
                foreach ($this->pages as $page) {                    
                    $pageNumber = urldecode(substr( $page, strrpos( $page, '/' ) +1 ));
                    $this->bookMetadata .= '<option value="' . $page . '">' . $pageNumber . '</option>';
                }
                $this->bookMetadata .= '</select>';    
                $this->bookMetadata .= '<input type="hidden" name="conf" value="' . $_REQUEST['conf'] . '" />';    
                $this->bookMetadata .= '<div><input type="submit" value="Go to page" /></div>';
            
                $this->bookMetadata .= '</form>';    
                $this->bookMetadata .= '</div>';   
            }
            if (isset($this->dataprovider) && $this->dataprovider != null) {
                $this->bookMetadata .= '<p><strong>Data provider:</strong><br/>' .
                                      $this->dataprovider . '</p><hr/>';    
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
            
            if (isset($this->pageLabel) && $this->pageLabel != null) {
                $this->pageMetadata .= '<h3>This page:</h3><br/><strong>Title: </strong>' . $this->pageLabel . '<hr/>';
                
            }
            
        }

        if ($this->shownBy) {
                $this->pageMetadata .= '<strong><a href="' . $this->shownBy . '" target="_blank">See object in its original Digital Library</strong><hr/>';
        }
        $this->pageMetadata .= '<small><a href="' . $this->url . '" target="_blank">See the RDF data</small>';

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
    
    private function retrieveBookmarklet() {
      $this->punditContent = $this->doCurlRequest('text/html');
      
        // =====================
        // Tr1: Add Absolute URI
        // =====================
        $url = parse_url($this->url);
        $domain = $url['host'];
        $this->punditContent = preg_replace('%href="//%','href="http://',$this->punditContent);
        $this->punditContent = preg_replace('%href="/%','href="http://'.$domain.'/',$this->punditContent);
        $this->punditContent = preg_replace('%src="//%','src="http://',$this->punditContent);
        $this->punditContent = preg_replace('%src="/%','src="http://'.$domain.'/',$this->punditContent);
              
        // ==================================
        // Tr2: Add JS and CSS to end of HEAD
        // ==================================        
        
        $conf="http://dev.thepund.it/download/client/last-beta/pundit2_conf.js";
        if(isset($_GET['conf'])) $conf=$_GET['conf'];
        
        $punditCode = <<<EOF
          <link rel="stylesheet" href="http://dev.thepund.it/download/client/last-beta/pundit2.css" type="text/css">        
          <script src="http://dev.thepund.it/download/client/last-beta/libs.js" type="text/javascript" ></script>
          <script src="http://dev.thepund.it/download/client/last-beta/pundit2.js" type="text/javascript" ></script>
          <script src="$conf" type="text/javascript" ></script>
EOF;
        $this->punditContent = 
          preg_replace('%<head>(.*)</head>%s','<head>$1 '.$punditCode.'</head>',$this->punditContent);
  
        // ====================================================
        // Tr3: Add data-app-ng="Pundit2" attribute to BODY TAG
        // ====================================================
        
        // BETA: if the page cointains at least one class="pundit-content" element
        // DO NOT ADD the pundit class, else add it to the body with the same URL
        
        if (preg_match('%class="pundit-content"%',$this->punditContent)){        
          $this->punditContent = 
            preg_replace('%<body%','<body data-ng-app="Pundit2" ',$this->punditContent);
        }
        else {
          $this->punditContent = 
            preg_replace('%<body([^>]*)>%s','<body data-ng-app="Pundit2" $1><div class="pundit-content" about="'.$this->url.'">',$this->punditContent);          
          $this->punditContent = 
            preg_replace('%</body>%','</div></body>',$this->punditContent);
        }
      
    }

    /** Takes care of more cases and remove all header **/
    private function retrievePunditContentAdvanced() {
      $this->retrievePunditContentDefault();
      $this->punditContent = preg_replace('@<body.*>@', '', $this->punditContent);
      $this->punditContent = preg_replace('@<head>.*</head>@s', '', $this->punditContent);
      $this->punditContent = preg_replace('@<html.*>@', '', $this->punditContent);
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
    
    private function showPagesPreview($pages) {
        $start = '';
        if (isset($_GET["start"]))
            $start = $_GET["start"];
        else 
            $start = 0;
        $max = 20;
        //sometime images are duplicated across different CHOs. We use a cache of URLs to check if it was already added.
        $shownPagesSoFar = null;
        $cont = 0;
        foreach ($pages as $page) {
            if ($cont < $start) {
                $cont++;
                continue;
            }
            if ($cont > ($start + $max)) break;
            $this->dm2eGraph->load($page);
            $agg = $this->getEDMAggregationOf($page);
            $versions = $this->dm2eGraph->allResources($agg,'dm2e:hasAnnotatableVersionAt');
            foreach($versions as $version) {
                if ($shownPagesSoFar && in_array($version,$shownPagesSoFar)) continue;
                $this->punditContent .=$this->showDM2EPage($page,$version);
                $shownPagesSoFar[$cont] = $version;
            }
            $cont++;
            
        }
        $link = '';
        if (isset($_GET["start"])) {
            $next = $_GET['start'] + $max;
            $link = str_replace('start='.$_GET["start"],'start=' . $next,$_SERVER['REQUEST_URI']);
        } else {
            $link = $_SERVER['REQUEST_URI'] . '&start=20';
        }
        $this->punditContent .= '<div><a href="' . $link . '">Next ' . $max . ' pages</a></div>';
        
    }
    
    private function showDM2EPage($page, $version) {
        $header = '';
        $title = $this->dm2eGraph->get($page, $this->nsDc . ':title');
        if (!$title) {
            $title = $this->dm2eGraph->get($page, $this->nsDc . ':description');    
        }
        $format = $this->dm2eGraph->get($version, $this->nsDc . ':format');
        if ($format == "image/jpeg" || $format == "http://onto.dm2e.eu/schemas/dm2e/1.1/mime-types/image/jpeg") {
            $header .= '<h4>Page: ' . $title . '</h4><small> <a href="' . '?dm2e=' . urlencode($page) . '&conf=dm2e.js">See this page only</a></small> | ';
            if ($this->shownBy) {
                    $header .= '<small><a href="' . $this->shownBy .
                                 '" target="_blank">Go to original DL</small> | ';
            }
            $header .= '<small><a href="' . $page . '" target="_blank">See the RDF data</a></small> | ';
            $header .= $this->showDM2EImage($version);
            $header .= '<hr/>';
        }
        return $header;    
    }
    
    private function showSinglePage() {
        
        // TODO: get the type of the resource from the RDF, and not with a string match!
        if (isset($this->annotableVersionAt)){
            $punditImageContent = null;
            $punditTextContent = null;
        
            foreach($this->annotableVersionAt as $version) {
                $format = $version->get($this->nsDc . ':format');
                /*
                if (!$format) {
                    $format = $this->aggregatedCHO->get($this->nsDc . ':format');
                }
                */
            
                if (($format == "image/jpeg" || $format == "http://onto.dm2e.eu/schemas/dm2e/1.1/mime-types/image/jpeg")) {
                
                    $punditImageContent .=$this->showDM2EPage($this->url,$version);
                
                } else if ($format == "text/html-named-content") {
                
                    $content = $this->doCurlRequest('text/html', $version);
                
                    $content = preg_replace('@<body>@', '', $content);
                    $content = preg_replace('@</body>@', '', $content);
                    $content = preg_replace('@<html>@', '', $content);
                    $content = preg_replace('@</html>@', '', $content);
            
                    $punditTextContent .= $content;
                
                } else if ($format == "text/html") {

                    // We assume that there is only html and body element and only one pundit content

                    $content = $this->doCurlRequest('text/html', $version);
                    $dom = new DOMDocument();
                    $dom->loadHTML($content);
            
                    $links = $dom->getElementsByTagName('head');
                    for ($i=0; $i<$links->length; $i++) {
                        $node = $links->item($i);
                        if ($node->parentNode)
                            $node->parentNode->removeChild($node);
                    }
                                
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'nodictionary orig') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'nodictionary norm') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'nodictionary reg') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'orig') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'reg') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $node->parentNode->removeChild($node);
                        }
                    }
            
                    $spans = $dom->getElementsByTagName('span');
                    for ($i=0; $i<$spans->length; $i++) {
                        $node = $spans->item($i);
                        $class = $node->getAttribute('class');
                        if ( ($class == 'norm') ) {
                            //$dom->removeChild($node);
                            //$node->textContent = '';
                            //$node->nodeValue = '';
                            $anchor = $node->parentNode;
                            if ($anchor->tagName=='a') {
                                    $anchor->setAttribute('target', '_blank');
                            }
                        }
                    }
            
                    $content = $dom->saveHTML();

                    $content = preg_replace('@<body>@', '', $content);
                    $content = preg_replace('@</body>@', '', $content);
                    $content = preg_replace('@<html>@', '', $content);
                    $content = preg_replace('@</html>@', '', $content);
            
                    $punditTextContent .= '
                         <div class="pundit-content" about="'. $version . '">'
                           . $content .
                         '</div>
                     ';
                } else {
                    $punditImageContent .= '
                         <div class="pundit-content" about="'. $version . '">
                           <img src="' . $version . '" class="annotable-image" />
                         </div>
                     ';
                }
            
            }
                
            if (!isset($punditImageContent) && $this->object) {
                $punditImageContent = '
                     <div class="pundit-content" about="'. $this->object . '">
                       <img src="' . $this->object . '" class="annotable-image" />
                     </div>
                 ';
            } else if (!isset($punditImageContent) && isset($this->pages) && count($this->pages)>0 && !$this->annotableVersionAt) {
                $p = $this->pages[0];
                $this->dm2eGraph->load($p);
                $agg = $this->getEDMAggregationOf($p);
                $versions = $this->dm2eGraph->allResources($agg, 'dm2e:hasAnnotatableVersionAt');
                foreach ($versions as $version) {
                    $format = $this->dm2eGraph->get($version, $this->nsDc . ':format');
                    if ($format == "image/jpeg" || $format == "http://onto.dm2e.eu/schemas/dm2e/1.1/mime-types/image/jpeg") {
                        $punditImageContent = $this->showDM2EImage($version);
                             
                    }
                }
                
                
            }
                
            if (isset($punditImageContent) && isset($punditTextContent)) {
                    $this->punditContent .= '<div class="pundit-content" about="' . $this->url .'">' . 
                        '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" 
                                resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $this->url . '"></span>' .
                        $punditImageContent .'</div>' .
                        '<hr/><h3>Transcription</h3>' . $punditTextContent;
            } else if (isset($punditImageContent)) {
                $this->punditContent .= '<div class="pundit-content" about="' . $this->url .'">' . 
                    '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" 
                            resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $this->url . '"></span>' .
                    $punditImageContent .
                    '</div>';
            } else if (isset($punditTextContent)) {
                $this->punditContent .= '<div class="pundit-content" about="' . $this->url .'">' . 
                    '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" 
                            resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $this->url . '"></span>' .
                    $punditTextContent .
                    '</div>';
            } else {
                $this->punditContent .= '
                    <div class="pundit-content" about="' . $this->url .'">' .
                '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" 
                        resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $this->url . '"></span>' .
                        '<div class="pundit-content" about="'.$this->object.'">';
                $this->punditContent .= '<img src="'.$this->object.'"  />';
                $this->punditContent .= '</div></div>';
            } 
        
        
        } else {
            $this->punditContent .= '
                <div class="pundit-content" about="' . $this->url .'">' . 
                    '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" 
                        resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $this->url . '"></span>' .
                    '<div class="pundit-content" about="'.$this->object.'">';
            $this->punditContent .= '<img src="'.$this->object.'"  />';
            $this->punditContent .= '</div></div>';
        
        }
        
    }
    

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
    
    private function getDM2EparentCHO($url) {
        $parent = $this->dm2eGraph->allResources($url, $this->nsDct . ':isPartOf');
        if (!$parent) {
            $parent = $this->dm2eGraph->resourcesMatching($this->nsDct . ':hasPart');
        }
        return $parent[0];
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
    
    private function showDM2eImage($version) {
        // XXX HACK for supporting RARA contentfrom MPIWG
        $suffix = 'http://digilib.mpiwg-berlin.mpg.de/digitallibrary/jquery/digilib.html?fn=/permanent/library/';
        $newsuffix = 'http://digilib.mpiwg-berlin.mpg.de/digitallibrary/servlet/Scaler?fn=/permanent/library/';
        $newpostfix = '&dw=1336&dh=680';
        if (strpos($version,$suffix) !== false) {
            $version = str_replace($suffix, $newsuffix, $version) . $newpostfix;

        }
    
        return '
                 <div class="pundit-content" about="'. $version . '">
                   <img src="' . $version . '" class="annotable-image" />
                 </div>
             ';
    }
    
    private function getDm2ePrevInSequence() {
        //echo "previous: " . $this->dm2eGraph->get($this->url, 'edm:isNextInSequence');
        return $this->dm2eGraph->get($this->url, 'edm:isNextInSequence');
    }

    // returns an array of Pages connected to the CHO via the dcterms:isPartOf relation
    private function getDm2ePages($url) {
        //echo "getting pages for .. " . $url;
        $parts = $this->dm2eGraph->resourcesMatching($this->nsDct . ':isPartOf');
        $pages = array();
        foreach ($parts as $part) {
            //echo "adding isPartOf ... " . $part;
            array_push($pages, $part);
        }
        $parts = $this->dm2eGraph->allResources($url, $this->nsDct . ':hasPart');
        foreach ($parts as $part) {
            //echo "adding hasPart ... " . $part;
            if (!in_array($part, $pages)) {
                    array_push($pages, $part);
            }                
        }
        sort($pages);
        return $pages;
    }

    private function getDm2eResourceArray($url, $property, $withMetadata) {
        $result = '';
        $cont = 0; 
        $authors = $this->dm2eGraph->allResources($url, $property);
        foreach ($authors as $auth) {
            try {
                $this->dm2eGraph->load($auth);         
            } catch(Exception $e) {
                //echo 'Message: ' .$e->getMessage();
            }
            
            $authorLabel = $this->dm2eGraph->get($auth, 'skos:prefLabel');     
            $result .= '<div class="pundit-content" about="' . $auth . '">';
            if ($withMetadata) {
                $result .= '<span class="pundit-ignore" rel="http://purl.org/pundit/ont/json-metadata" resource="http://feed.thepund.it/services/rdftojsonld.php?url=' . $auth . '" style="" width=""></span>';
            }
            $result .= $authorLabel ;
            $cont++;
            $result .= '</div>';
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
        $date = null;
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

    public static function hasEE($conf) {
        return ($conf == 'bur-debug.js' || $conf == 'burckhardt-dev.js' || $conf = 'burckhardt.js' );
    }

}