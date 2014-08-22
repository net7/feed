<?php

require_once(dirname(__FILE__) . '/../lib/FusepoolScraper.class.php');

// When you click the "finish" button in pundit, it ships back all the data we need to exit and get back to
// the Fusepool platform, via its APIs.
//
// if $_GET['punditSaveRequest'] is set, the user clicked the finish button.
if (isset($_GET['punditSaveRequest'])) {
    // we get the data from the request (there's json in the body)
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);

    $punditContent = $data['punditContent'];
    $html = htmlspecialchars_decode($data['punditPage']);

    // TODO: pass it by thepund.it, taking it from the conf
    $asBaseUrl = 'http://demo-cloud.as.thepund.it:8080/annotationserver/';
    $apiUrl = $asBaseUrl . 'api/open/metadata/search?scope=all&query={"resources":["' . $punditContent . '"]}';

    $annotations = callCURL($apiUrl, 'dealWithAnnotations');
    print_r($annotations); die();

} else if (!isset($_GET['m'])){

    $s = new FusepoolScraper();
    $md5 = $s->doFirstTransformations();
?>
    <html>
    <body>

<form id="passOn" action="?fp=on&m=<?php echo $md5;?>" method="post">
    <textarea style="display:none" name="data"><?php echo $_POST['data'];?></textarea>
</form>

<script>
    document.getElementById("passOn").submit();

</script>

    </body>
    </html>
<?php

    die();

} else {
    // we are entering Pundit, so we need to prepare all the data and instantiate it

    try {
        $s = new FusepoolScraper();
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    echo $s->getPunditContent();

}


/**
 * @param $apiUrl
 * @param $successFunction
 * @param string $accept
 * @return string
 *
 * Contacts the Annotation Server (via the $apiUrl URL) and calls the $successFunction on success.
 * Returns the data retrieved and manipulated by the $successFunction.
 * The $accept param is used to tell the AS in which format we want the data to be formatted.
 *
 */
function callCURL($apiUrl, $successFunction, $accept = 'json')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    switch ($accept) {
        case 'n3':
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/rdf+n3'));
            break;
        case 'rdf':
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/rdf+xml; charset=utf-8'));
            break;
        case 'json':
        default:
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            break;
    }
    $content = curl_exec($ch);
    $response = curl_getinfo($ch);
    curl_close($ch);

    switch ($response['http_code']) {
        case 204:
            // no content
            // No annotations retrieved from the Annotation server.
            $annotations = '';
            break;
        case 200:
            // ok
            // so the $response variable contains the RDF
            $annotations = $successFunction($content);
            break;
        case 400:
        case 500:
        default:
            // some errors occurred
            // TODO: ship useful errors.
            quitWithError($content);
            break;

    }

    return $annotations;
}

/**
 * @param $jsonContent
 *
 * Get the annotations data (in $jsonContent) and process them by calling the AS for each of them, and retrieving the graph,
 * the items and the metadata
 *
 * Returns the whole stuff
 */
function dealWithAnnotations($jsonContent)
{
    global $asBaseUrl;
    $content = json_decode($jsonContent, true);
    $result = array();
    foreach ($content as $annotationData) {
        $annotationId = $annotationData['http://purl.org/pundit/ont/ao#id'][0]['value'];

        $metadataUrl = $asBaseUrl . 'api/open/annotations/' . $annotationId . '/metadata';
        $graphUrl = $asBaseUrl . 'api/open/annotations/' . $annotationId . '/graph';
        $itemsUrl = $asBaseUrl . 'api/open/annotations/' . $annotationId . '/items';

        $graph = callCURL($graphUrl, 'returnInput', 'n3');
        $metadata = callCURL($metadataUrl, 'returnInput', 'n3');
        $items = callCURL($itemsUrl, 'returnInput', 'n3');

        $annotation = array(
            'graph' => $graph,
            'metadata' => $metadata,
            'items' => $items
        );
        $result []= $annotation;

    }
    return $result;
}

function returnInput($input)
{
    return $input;
}

function quitWithError($content)
{
    FusepoolScraper::abortToFP($content);
}