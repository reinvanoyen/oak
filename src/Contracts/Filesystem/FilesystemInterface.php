<?php

namespace Oak\Contracts\Filesystem;

/**
 * Interface FilesystemInterface
 * @package Oak\Contracts\Filesystem
 */
interface FilesystemInterface
{
	/**
	 * @param string $path
	 * @return bool
	 */
	public function exists(string $path): bool;

	/**
	 * @param string $path
	 * @return bool
	 */
	public function isWriteable(string $path): bool;

	/**
	 * @param string $path
	 * @return bool
	 */
	public function isReadable(string $path): bool;

	public function size(string $path): int;

	/**
	 * @param string $path
	 * @return string
	 */
	public function mimetype(string $path): string;

	/**
	 * @param string $path
	 * @return int
	 */
	public function modificationTime(string $path): int;

	/**
	 * @param string $path
	 * @return mixed
	 */
	public function get(string $path);

	/**
	 * @param string $path
	 * @param $contents
	 * @return mixed
	 */
	public function put(string $path, $contents);

	/**
	 * @param string $path
	 * @param $contents
	 * @return mixed
	 */
	public function prepend(string $path, $contents);

	/**
	 * @param string $path
	 * @param $contents
	 * @return mixed
	 */
	public function append(string $path, $contents);

	/**
	 * @param string $path
	 * @return array
	 */
	public function files(string $path): array;

	/**
	 * @param string $path
	 * @return mixed
	 */
	public function delete(string $path);

	/**
	 * @param string $path
	 * @param string $newPath
	 * @return mixed
	 */
	public function move(string $path, string $newPath);
}