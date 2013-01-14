<?php

class Scraper {
    private $url;
    /**
     * Public contructor set URL to be scraped
     * TODO: verify if the url is valid
     * TODO: Test
     * @param type $url 
     */
    public function __construct($url) {
        $this->url=$url;
        if(!$this->isUrlValid())            
                throw new Exception('Url is not VALID');
    }
    
    
    
    public function getHasAnnotableVersionAt() {
        
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
     * Retrieve pundit content throough the content neg
     * // TODO: ALL!!!!!
     */
    public function getPunditContent() {
        $rdf = $this->doCurlRequest('application/rdf+xml');
        preg_match('@korbo:hasAnnotableVersionAt.*@', $rdf, $matches);
        $string = $matches[0];
        $string1 = preg_replace('@korbo:hasAnnotableVersionAt rdf:resource="@', '', $string);
        $htmlUrl = preg_replace('@".*@', '', $string1);
        $content = $this->doCurlRequest('text/html',$htmlUrl);     
        $content = preg_replace('@<body>@', '', $content);
        $content = preg_replace('@</body>@', '', $content);
        $content = preg_replace('@<html>@', '', $content);
        $content = preg_replace('@</html>@', '', $content);
        return $content;
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