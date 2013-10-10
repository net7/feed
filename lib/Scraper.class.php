<?php

class Scraper {

    private $url;
    private $urlType;
    private $label;
    private $comment;
    private $annotableVersionAt;
    private $domain;
    private $punditContent;
    private $prev = false;
    private $next = false;
    private $stylesheet = false;

    /**
     * Public contructor set URL to be scraped
     * TODO: verify if the url is valid
     * TODO: Test
     * @param type $url 
     */
    public function __construct($url, $urlType=NULL) {
        $this->url = $url;
        if (!$this->isUrlValid())
            throw new Exception('Url is not VALID');
        $this->setUrlType($urlType);
        $this->retrievePunditContent();
    }
    
    private function setUrlType($urlType) {
        $allowed_types = array ('default','img');
        if($urlType==null) $this->urlType='default';
        else if (in_array($urlType, $allowed_types))
                $this->urlType=$urlType;
        else            throw new Exception('Url Type '.$urlType.' Not allowed');
    }
    
    public function getPunditContent() {
        return $this->punditContent;
    }

    public function getLabel() {
        return $this->label;
    }
    public function getNext($pos = null) {
        $s = $_SERVER['HTTP_HOST'];
        
        if (!$this->next)
            return false;
        
        // Single page annotation
        if (!isset($_REQUEST['lurl']) && !isset($_REQUEST['rurl'])) {
            return 'http://'. $s .'/?url='. $this->next .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "left") {
            return 'http://'. $s .'/?lurl='. $this->next .'&rurl='. $_REQUEST['rurl'] .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "right") {
            return 'http://'. $s .'/?rurl='. $this->next .'&lurl='. $_REQUEST['lurl'] .'&conf='. $_REQUEST['conf'];
        }
    }
    
    public function getPrev($pos = null) {
        $s = $_SERVER['HTTP_HOST'];
        
        if (!$this->prev)
            return false;
        
        // Single page annotation
        if (!isset($_REQUEST['lurl']) && !isset($_REQUEST['rurl'])) {
            return 'http://'. $s .'/?url='. $this->prev .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "left") {
            return 'http://'. $s .'/?lurl='. $this->prev .'&rurl='. $_REQUEST['rurl'] .'&conf='. $_REQUEST['conf'];
        } else if ($pos == "right") {
            return 'http://'. $s .'/?rurl='. $this->prev .'&lurl='. $_REQUEST['lurl'] .'&conf='. $_REQUEST['conf'];
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

        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $requestUrl);
        curl_setopt($request, CURLOPT_HTTPHEADER, array("Content-Type: {$contentType}"));
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
            default:
                throw new Exception('Url type '.$this->urlType.' not supported.');
                break;
        }
    }

    
    private function retrievePunditContentDefault() {
        $rdf = $this->doCurlRequest('application/rdf+xml');
        $dom = new DOMDocument();
        $dom->loadXML($rdf);

        $this->label = $this->extractLabelByDom($dom);
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
        $this->label = 'Web image : '.$this->url;
        $this->comment = 'Single image pundit annotator';
        $url_info=parse_url($this->url);
        $this->domain=$url_info['host'];
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
    
    private function extractTagValueByDom(DOMDocument $dom,$tagname) {
        $values = $dom->getElementsByTagName($tagname);
        $val='';
        foreach ($values as $value){
           $val = $value->nodeValue;
        }
        return $val;
    }

    private function extractAttributeValueByDom(DOMDocument $dom,$tagname,$attributename) {
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
        return filter_var($this->url, FILTER_VALIDATE_URL);
    }

    public function getUrl() {
        return $this->url;
    }

}