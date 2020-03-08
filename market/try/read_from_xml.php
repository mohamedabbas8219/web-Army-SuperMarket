<?php
libxml_use_internal_errors(true);
$myXMLData =readfile("products.xml"); 

$xml = simplexml_load_string($myXMLData);
if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
    print_r($xml);
}
//echo readfile("test.txt");