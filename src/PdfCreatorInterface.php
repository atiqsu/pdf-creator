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

use Closure;

interface PdfCreatorInterface
{
    /**
     * Create pdf from $url
     *
     * @param  string        $url      The url to load the resource html
     * @param  string        $path     The path to save pdf
     * @param  \Closure|null $callback The callback to call after creation succesfull
     * @return void
     */
    public function url($url, $path, Closure $callback = null);

    /**
     * Create pdf from a file
     *
     * @param string        $filePath Path to file to resource html
     * @param string        $path     Path to save pdf file
     * @param \Closure|null $callback The callback to call after creation succesfull
     * @return void
     */
    public function file($filePath, $path, Closure $callback = null);

    /**
     * Create pdf file from raw html
     *
     * @param string        $filePath Path to file to resource html
     * @param string        $path     Path to save pdf file
     * @param \Closure|null $callback The callback to call after creation succesfull
     * @return void
     */
    public function raw($html, $path, Closure $callback = null);
}
