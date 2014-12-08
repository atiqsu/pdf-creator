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
use Symfony\Component\Process\Process;

class WkHtmlToPdfCreator implements PdfCreatorInterface
{

    /**
     * {$inheritDoc}
     */
    public function url($url, $path, Closure $callback = null)
    {
        $this->runProcess($url, $this->getRealPath($path), $callback);
    }

    /**
     * {$inheritDoc}
     */
    public function file($filePath, $path, Closure $callback = null)
    {
        if (! file_exists($filePath)) {
            throw new \Exception("$filePath not exists");
        }

        $this->runProcess($filePath, $this->getRealPath($path), $callback);

    }

    /**
     * {$inheritDoc}
     */
    public function raw($html, $path, Closure $callback = null)
    {
        $temp = sys_get_temp_dir().'/php'.substr(sha1(rand()), 0, 6);
        $err = file_put_contents($temp, $html);

        if($err === false)
        {
            throw new \Exception('Error creating temp file when creating pdf.');
        }

        $this->runProcess($temp, $output = $this->getRealPath($path), $callback);
    }

    /**
     *
     */
    protected function runProcess($viewPath, $outputFile, Closure $callback = null)
    {
        $this->getWkhtmlProcess($viewPath, $outputFile)->run();

        if(file_exists($outputFile) && isset($callback))
        {
            $callback($outputFile);
        }
    }

    /**
     *
     */
    protected function getWkhtmlProcess($viewPath, $outputFile)
    {
        $wkhtml = __DIR__.'/bin/'.$this->getSystem();

        return new Process($wkhtml.' '. $viewPath.' '.$outputFile, __DIR__);
    }

    /**
     *
     */
    protected function getRealPath($path)
    {
        return strpos($path, '.pdf') !== false ? $path : $path.'.pdf';
    }

    /**
     *
     */
    protected static function getSystem()
    {
        $uname = strtolower(php_uname());

        if(strpos($uname, 'linux') !== false )
        {
            return PHP_INT_SIZE === 4 ? 'linux-i386' : 'linux-amd64';
        }

        throw new \Exception("{$uname} system not supported yet.");

    }
}
