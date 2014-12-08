<?php
/**
 * Get the autoload file
 */
require __DIR__.'/../vendor/autoload.php';

use Memtoko\PdfCreator\PdfCreator;

$url = 'https://www.google.com';

$creator = new PdfCreator;
/**
 * Require GuzzleHttp to use url
 */
$creator->url($url, __DIR__.'/google.pdf', function($path)
{
    echo $path;
});
