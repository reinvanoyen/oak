<?php

namespace Oak\Session;

use Oak\Contracts\Filesystem\FilesystemInterface;
use SessionHandlerInterface;

/**
 * Class FileSessionHandler
 * @package Oak\Session
 */
class FileSessionHandler implements SessionHandlerInterface
{
	/**
	 * Handles working with files
	 *
	 * @var FilesystemInterface $filesystem
	 */
	private $filesystem;

	/**
	 * Path to store the sessions
	 *
	 * @var string
	 */
	private $path;

	/**
	 * FileSessionHandler constructor.
	 *
	 * @param FilesystemInterface $filesystem
	 * @param string $path
	 */
	public function __construct(FilesystemInterface $filesystem, string $path)
	{
		$this->filesystem = $filesystem;
		$this->path = $path;
	}

	/**
	 * @return bool
	 */
	public function close()
	{
		return true;
	}

	/**
	 * Destroy the session with given session id
	 *
	 * @param string $sessionId
	 * @return bool
	 */
	public function destroy($sessionId)
	{
		$this->filesystem->delete($this->path.'/'.$sessionId);

		return true;
	}

	/**
	 * Garbage collection
	 *
	 * @param int $maxLifeTime
	 * @return bool
	 */
	public function gc($maxLifeTime)
	{
		$now = time();
		$files = $this->filesystem->files($this->path);

		foreach ($files as $filePath) {
			if ($this->filesystem->modificationTime($filePath) + $maxLifeTime < $now) {
				$this->filesystem->delete($filePath);
			}
		}

		return true;
	}

	/**
	 * Session start
	 *
	 * @param string $savePath
	 * @param string $name
	 * @return bool
	 */
	public function open($savePath, $name)
	{
		return true;
	}

	/**
	 * Read session data by given session id
	 *
	 * @param string $sessionId
	 * @return string
	 */
	public function read($sessionId)
	{
		if ($this->filesystem->exists($this->path.'/'.$sessionId)) {
			return $this->filesystem->get($this->path.'/'.$sessionId);
		}

		return '';
	}

	/**
	 * Write data to session
	 *
	 * @param string $sessionId
	 * @param string $sessionData
	 * @return bool
	 */
	public function write($sessionId, $sessionData)
	{
		$this->filesystem->put($this->path.'/'.$sessionId, $sessionData);

		return true;
	}
}