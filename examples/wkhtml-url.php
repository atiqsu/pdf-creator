<?php
/**
 * Get the autoload file
 */
require __DIR__.'/../vendor/autoload.php';

use Memtoko\PdfCreator\WkHtmlToPdfCreator;

$wkhtml = new WkHtmlToPdfCreator;

$wkhtml->url('http://www.google.com', __DIR__.'/google.pdf', function($path)
{
    echo $path;
});
