<?php

/*
 * This file is part of the Memtoko PdfCreator.
 *
 * (c) Syaiful Bahri <syaiful@memtoko.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Memtoko\PdfCreator;

use DOMPDF;
use Closure;
use GuzzleHttp\Client;

class PdfCreator implements PdfCreatorInterface
{
    /**
     * Create pdf from $url
     *
     * @param  string        $url      The url to load the resource html
     * @param  string        $path     The path to save pdf
     * @param  \Closure|null $callback A callback to call before create pdf
     * @return int|boolean If can't create return false
     */
    public function url($url, $path, Closure $callback = null)
    {
        $response = $this->getClient()->get($url);

        return $this->raw($response->getBody(), $path, $callback);
    }

    /**
     * Create pdf from a file
     *
     * @param string        $filePath Path to file to resource html
     * @param string        $path     Path to save pdf file
     * @param \Closure|null $callback The callback to configure the creation of pdf
     * @return int|boolean If can't create return false
     */
    public function file($filePath, $path, Closure $callback = null)
    {
        if (! file_exists($filePath)) {
            throw new \Exception("$filePath not exists");
        }

        $html = file_get_contents($filePath);

        return $this->raw($html, $path, $callback);
    }

    /**
     * Create pdf file from raw html
     *
     * @param string        $html     The html to convert to pdf
     * @param path          $path     The Path to save pdf file
     * @param \Closure|null $callback The callback to configure the creation of pdf
     * @return int|boolean If can't create return false
     */
    public function raw($html, $path, Closure $callback = null)
    {
        $dompdf = new DOMPDF();

        if (isset($callback)) {
            call_user_func($callback, $dompdf);
        }

        $dompdf->load_html($html);
        $dompdf->render();

        return file_put_contents($path, $dompdf->output());
    }

    /**
     * Get new instance of GuzzleHttp Client
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client();
    }
}
