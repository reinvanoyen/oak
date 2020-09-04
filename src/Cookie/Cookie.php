<?php

namespace Oak\Cookie;

use Oak\Contracts\Cookie\CookieInterface;

/**
 * This class provides a simple PHP interface for working with cookies.
 *
 * @package Oak
 * @author Rein Van Oyen <reinvanoyen@gmail.com>
 */
class Cookie implements CookieInterface
{
    /**
     * @var string $path
     */
    private $path;

    /**
     * @var bool $secure
     */
    private $secure;

    /**
     * @var bool $httpOnly
     */
    private $httpOnly;

    /**
     * Cookie constructor.
     * @param string $path
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function __construct(string $path, bool $secure, bool $httpOnly)
    {
        $this->path = $path;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
    }

    /**
     * @param string $name
     * @param $value
     * @param int $expire
     * @return mixed|void
     */
    public function set(string $name, $value, int $expire = 0)
    {
        $value = json_encode($value);
        setcookie($name, $value, $expire, $this->path, '', $this->secure, $this->httpOnly);
        $_COOKIE[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return json_decode($_COOKIE[$name]);
        }

        return null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return (isset($_COOKIE[$name]));
    }
}