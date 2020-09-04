<?php

namespace Oak\Database\Traits;

trait HasAttributes
{
    /**
     * @var array $attributes
     */
    private $attributes = [];

    /**
     * @param string $name
     * @param $value
     */
    public function setAttribute(string $name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name] ?? null;
    }
}