<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../autoload.php');

use mcsaba\FaxPDFConvert\FaxPDFConvert;

$pdfMaker = new FaxPDFConvert(__DIR__ . '/../data/people.json', __DIR__ . '/../data/faxes', __DIR__ . '/../data/pdf');
$result = $pdfMaker->process();

echo '<pre>';
print_r($result);
echo '</pre>';