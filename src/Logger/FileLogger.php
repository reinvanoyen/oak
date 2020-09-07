<?php

namespace Oak\Logger;

use Oak\Contracts\Logger\LoggerInterface;
use Oak\Filesystem\DiskManager;

/**
 * Class that writes logs to a file.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class FileLogger implements LoggerInterface
{
    /**
     * @var string $filename
     */
    private $filename;
    
    /**
     * @var string $disk
     */
    private $disk;
    
    /**
     * @var string $dateFormat
     */
    private $dateFormat;
    
    /**
     * @var DiskManager $diskManager
     */
    private $diskManager;

    /**
     * FileLogger constructor.
     * @param string $filename
     * @param string $disk
     * @param string $dateFormat
     * @param DiskManager $diskManager
     */
    public function __construct(string $filename, string $disk, string $dateFormat, DiskManager $diskManager)
    {
        $this->filename = $filename;
        $this->disk = $disk;
        $this->dateFormat = $dateFormat;
        $this->diskManager = $diskManager;
    }

    /**
     * @param string $text
     */
    public function log(string $text)
    {
        $date = date($this->dateFormat);
        $line = $date.' - '.$text;
        
        $this->diskManager->disk($this->disk)
            ->append($this->filename, $line."\n");
    }
}