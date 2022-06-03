<?php

namespace Model;
/**
 * Class that makes out object data readable as an array
 */
class HeroCollection implements \ArrayAccess, \IteratorAggregate
{
    private $heroes;

    public function __construct(array $heroes)
    {
        $this->heroes = $heroes;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->heroes);
    }

    public function offsetGet($offset)
    {
        return $this->heroes[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->heroes[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->heroes[$offset]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->heroes);
    }
}
