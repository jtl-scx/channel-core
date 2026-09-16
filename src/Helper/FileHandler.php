<?php
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 16/01/19
 */

namespace JTL\SCX\Lib\Channel\Helper;

use RuntimeException;

class FileHandler
{
    /**
     * @param string $fileName
     * @param string $mode
     * @return resource
     */
    public function open(string $fileName, string $mode)
    {
        $resource = @fopen($fileName, $mode);
        if ($resource === false) {
            throw new RuntimeException("Could not open file '{$fileName}' in mode '{$mode}'");
        }

        return $resource;
    }

    /**
     * @param resource $fileResource
     * @param string $content
     * @return bool|int
     */
    public function write($fileResource, string $content)
    {
        return fwrite($fileResource, $content);
    }

    /**
     * @param resource $fileResource
     * @return bool
     */
    public function close($fileResource): bool
    {
        return fclose($fileResource);
    }

    /**
     * @param resource $fileResource
     * @return bool
     */
    public function rewind($fileResource): bool
    {
        return rewind($fileResource);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function isFile(string $fileName): bool
    {
        return is_file($fileName);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function unlink(string $fileName): bool
    {
        return unlink($fileName);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function readContent(string $filename): string
    {
        $content = @file_get_contents($filename);
        if ($content === false) {
            throw new RuntimeException("Could not read file '{$filename}'");
        }

        return $content;
    }
}
