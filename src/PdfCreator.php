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
     * {$inheritDoc}
     */
    public function url($url, $path, Closure $callback = null)
    {
        $response = $this->getClient()->get($url);

        return $this->raw($response->getBody(), $path, $callback);
    }

    /**
     * Create pdf from a file
     *
     * {$inheritDoc}
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
     * {$inheritDoc}
     */
    public function raw($html, $path, Closure $callback = null)
    {
        $dompdf = new DOMPDF();

        $dompdf->load_html($html);
        $dompdf->render();

        $err = file_put_contents($path, $dompdf->output());

        if (isset($callback) && $err !== false) {
            call_user_func($callback, $dompdf);
        }
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
