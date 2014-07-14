<?php

require_once(dirname(__FILE__) . '/Scraper.class.php');


class FusepoolScraper extends Scraper {


    private $data;
    private $savedHTML;

    private $Fp3Ns = 'http://vocab.fusepool.info/fp3#';
    private $RDFHtmlTag = 'html';

    /**
     * Public contructor gets the data to be annotated, either in HTML or RDF format (containing the HTML)
     * from the 'data' variable, sent via a POST request.
     */
    public function __construct() {
        $this->data = $_POST['data'];
        $this->retrievePunditContentDefault();
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
        return $this->getPunditContent();
    }

    public function getLabel() {
        return $this->bookLabel;
    }
    
    public function getNext($pos = null) {
        return false;
    }
    
    public function getPrev($pos = null) {
        return false;
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

    /*
     * Extracts the HTML from the input data.
     * It can be either the whole data var or, if the data is RDF, nested into some nodes of such RDF
     */
    private function extractHtmlFromData(){

        $data = $this->data;

        $dom = new DOMDocument("1.0", "utf-8");
        $dom->loadXML($data);

        $FPhtmlNodeList = $dom->getElementsByTagNameNS($this->Fp3Ns, $this->RDFHtmlTag);

        if ($FPhtmlNodeList->length != 0){
            // this is a well-formed RDF with a RDF:HTML literal node containing the HTML, we take it
            $FPHtmlNode = $FPhtmlNodeList->item(0);
            $htmlNodeList = $FPHtmlNode->getElementsByTagName('html');
            $htmlNode = $htmlNodeList->item(0);
            return $dom->saveHTML($htmlNode);
        } else {
            // this is not a well-formed RDF documents, let's see if it's an HTML one
            return $dom->saveHTML();
        }

    }

    private function retrievePunditContentDefault() {
        $this->punditContent = $this->extractHtmlFromData();

        if (!$this->punditContent){
            self::abortToFP();
        }

        // ==================================
        // Check if there's and HEAD section
        // ==================================
        $dom = new DOMDocument();
        $dom->loadHTML($this->punditContent);

        $headNodeList = $dom->getElementsByTagName('head');
        $l =  $headNodeList->length;

        if($l == 0){
            // we need to add an head section to the HTML
            $this->punditContent =
                preg_replace('%<html>(.*)%s', '<html><head></head>$1', $this->punditContent);
        }
        // ====================================================
        //   Add data-app-ng="Pundit2" attribute to BODY TAG
        //   And a pundit-content
        // ====================================================

        $punditAboutCode = 'fusepool-' . md5($this->data);

        if (preg_match('%class="pundit-content"%',$this->punditContent)){
            $this->punditContent =
                preg_replace('%<body%','<body data-ng-app="Pundit2" ',$this->punditContent);
        }
        else {
            $this->punditContent =
                preg_replace('%<body([^>]*)>%s','<body data-ng-app="Pundit2" $1><div class="pundit-content" about="'.$punditAboutCode.'">',$this->punditContent);
            $this->punditContent =
                preg_replace('%</body>%','</div></body>',$this->punditContent);
        }

        $this->savedHTML = $this->punditContent;

        // ==================================
        // Add JS and CSS to end of HEAD
        // ==================================

        $punditCode = <<<EOF
          <link rel="stylesheet" href="pundit2/pundit2.css" type="text/css">
          <script src="pundit2/libs.js" type="text/javascript" ></script>
          <script src="pundit2/pundit2.js" type="text/javascript" ></script>
          <script src="http://conf.thepund.it/V2/clients/fusepool.js" type="text/javascript" ></script>
EOF;

        $this->punditContent =
            preg_replace('%<head>(.*)</head>%s','<head>$1 '.$punditCode.'</head>',$this->punditContent);


        // save the HTML in an hidden place so to be able to send it back to the FP platform at the end of the process
        $this->punditContent =
            preg_replace('%</body>%s', '<div style="display:none" id="html-storage">' . htmlspecialchars($this->savedHTML). '</div></body>', $this->punditContent);


    }

    /**
     * Quits the execution and get back to the Fusepool platform passing an error message
     *
     * @param $message - The message to be sent
     * TODO: ALL
     */

    public static function abortToFP($message = ''){
        // TODO: get the message, construct a result for the FP platform and ship it back
        die('ABORT TO FP' . $message);
    }

    /**
     * @param $foo - just for compatibility with parent's method
     * @return bool
     *
     */
    public static function hasEE($foo) {
        return false;
    }

}