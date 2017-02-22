<?php
//$doc = new DOMDocument();
//$doc->loadHTML("<html><body>Test<br></body></html>");
//echo $doc->saveHTML();

//$xml = simplexml_load_file("test.xml");
//$products = $xml->xpath("/PRODUCTS");
////var_dump($products);
//print_r($products);


$doc = new DOMDocument;
$doc->load('test.xml');
$xpath = new DOMXPath($doc);
$products = $xpath->query("/PRODUCTS/PRODUCT[SKU='soft32323']/NAME");
var_dump($products);
 
foreach ($products as $product){
   print($product->nodeValue)."<br>";
}