#!/usr/bin/env php
<?php
// expect that there is a file input
if (!isset($argv[1]) || !file_exists($argv[1])) {
  echo "Usage $argv[0] <filename>\n";
}
$app = 'testapp';
$md5 = md5(uniqid());
define('API_KEY', $app . $md5);
define('SERVICE_URL', 'http://service.afterthedeadline.com/');

$text = file_get_contents($argv[1]);
$length = strlen($text);
//echo $length . "\n";
//echo API_KEY . "\n";
//exit;
$header = array(
  'Content-length: ' . $length,
  'Accept: application/xml',
  'Expect:',
  );
$data = array(
  'key' => API_KEY,
  'data' => $text,
);

//$function = 'checkDocument';
//$function = 'checkGrammar';
$function = 'stats';
/**
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SERVICE_URL . $function);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_POST, 1);

$result = curl_exec($ch);
$info = curl_getinfo($ch);

echo "INFO: " . print_r($info, TRUE);
echo "\n=========================================\n";
echo "RESULT: " . print_r($result, TRUE);
echo "\n=========================================\n";
**/
$query = array();
foreach ($data as $key => $val) {
  $query[] = $key . '=' . urlencode($val);
}

$request_uri = SERVICE_URL . $function . '?' . implode('&', $query);
$result = file_get_contents($request_uri);

print_r($result);
$xml = simplexml_load_string($result);

print_r($xml);
