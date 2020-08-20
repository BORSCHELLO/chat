<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use ReflectionObject;

class TestPrivateHelper
{
    private $obj;

    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    public function get(string $name)
    {
        $r = new ReflectionObject($this->obj);

        $property = $r->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue($this->obj);
    }

    public function set(string $name, $value)
    {
        $r = new ReflectionObject($this->obj);

        $property = $r->getProperty($name);
        $property->setAccessible(true);

        $property->setValue($this->obj, $value);
    }
}