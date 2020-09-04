<?php

namespace Oak\Filesystem;

use Oak\Contracts\Filesystem\FilesystemInterface;

/**
 * This class provides an easy to understand PHP interface for working with 
 * local files and directories.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class LocalFilesystem implements FilesystemInterface
{
    /**
     * Check if the file at path exists
     *
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * Checks if the file at path is writeable
     *
     * @param string $path
     * @return bool
     */
    public function isWriteable(string $path): bool
    {
        return is_writable($path);
    }

    /**
     * Checks if the file at path is readable
     *
     * @param string $path
     * @return bool
     */
    public function isReadable(string $path): bool
    {
        return is_readable($path);
    }

    /**
     * Gets the filesize of the file at path in bytes
     *
     * @param string $path
     * @return int
     */
    public function size(string $path): int
    {
        return filesize($path);
    }

    /**
     * Gets the mimetype of the file at path
     *
     * @param string $path
     * @return string
     */
    public function mimetype(string $path): string
    {
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
    }

    /**
     * Get the last modification time of the file at path
     *
     * @param string $path
     * @return int
     */
    public function modificationTime(string $path): int
    {
        return filemtime($path);
    }

    /**
     * Gets the contents of the file at path
     *
     * @param string $path
     * @return string
     */
    public function get(string $path)
    {
        return file_get_contents($path);
    }

    /**
     * Writes contents to the file at path
     *
     * @param string $path
     * @param $contents
     */
    public function put(string $path, $contents)
    {
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0766, true);
        }

        file_put_contents($path, $contents);
    }

    /**
     * Prepends contents to the file at path
     *
     * @param string $path
     * @param $contents
     */
    public function prepend(string $path, $contents)
    {
        if ($this->exists($path)) {
            $this->put($path, $contents.$this->get($path));
            return;
        }

        $this->put($path, $contents);
    }

    /**
     * Append contents to the file at path
     *
     * @param string $path
     * @param $contents
     */
    public function append(string $path, $contents)
    {
        if ($this->exists($path)) {
            $this->put($path, $this->get($path).$contents);
            return;
        }

        $this->put($path, $contents);
    }

    /**
     * Deletes the file at path
     *
     * @param string $path
     */
    public function delete(string $path)
    {
        unlink($path);
    }

    /**
     * Moves the file to the target
     *
     * @param string $path
     * @param string $target
     */
    public function move(string $path, string $target)
    {
        $dir = dirname($target);
        if (!file_exists($dir)) {
            mkdir($dir, 0766, true);
        }

        rename($path, $target);
    }

    /**
     * Copies the file to the target
     *
     * @param string $path
     * @param string $target
     * @return mixed|void
     */
    public function copy(string $path, string $target)
    {
        $dir = dirname($target);
        if (!file_exists($dir)) {
            mkdir($dir, 0766, true);
        }

        copy($path, $target);
    }

    /**
     * Get all files in a directory
     *
     * @param string $path
     * @return array
     */
    public function files(string $path): array
    {
        return array_filter(glob($path.'/*'), 'is_file');
    }

    /**
     * Get all directories in a directory
     *
     * @param string $path
     * @return array
     */
    public function directories(string $path): array
    {
        return array_filter(glob($path.'/*'), 'is_dir');
    }
}