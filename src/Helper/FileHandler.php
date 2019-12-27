<?php
/**
 * This File is part of JTL-Software
 *
 * User: mbrandt
 * Date: 16/01/19
 */

namespace JTL\SCX\Lib\Channel\Helper\File;

class FileHandler
{
    /**
     * @param string $fileName
     * @param string $mode
     * @return resource
     */
    public function open(string $fileName, string $mode)
    {
        return fopen($fileName, $mode);
    }

    /**
     * @param $fileResource
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
        return file_get_contents($filename);
    }
}
