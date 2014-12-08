PDF Creator for PHP
==================

A beautifull syntax pdf creation for php. Create PDF file is regular task for
web development, however it's not easy task.

This package come to help you create pdf file in easy way, provide a beautiful interface
that easy to read. The easy way to create PDF file is from HTML. Because we are familiar with it instead draw.

For now its support WkHtmlToPdf and DOMPDF.

### Example

````
use Memtoko\PdfCreator\PdfCreator;

$url = 'https://www.google.com';

$creator = new PdfCreator;
/**
 * Require GuzzleHttp to use url
 */
$creator->url($url, __DIR__.'/google.pdf');
````

Or if you want create from html file.

````
use Memtoko\PdfCreator\PdfCreator;

$creator = new PdfCreator;

$creator->file($pathToHtmlFile, $pathToSave');
````

This package also support creation from raw html, use raw method for it.
Here the example to create pdf file from raw html that returned from laravel view.
````
use Memtoko\PdfCreator\PdfCreator;
use Illuminate\View\Factory;

$creator = new PdfCreator;
$html = $viewFactory->make('invoices.order', ['number' => 3242])->render();

$creator->raw($html, $pathToSave');
````
