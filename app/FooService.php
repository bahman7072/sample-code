<?php
/**
 * Created by PhpStorm.
 * User: Bahman
 * Date: 22/04/2020
 * Time: 02:29 PM
 */

namespace App;


class FooService
{
    public function doSomething($type, $name)
    {
        return 'Do Something ' . $type . ' ' . $name;
    }

    public function max($first, $second)
    {
        return $first + $second;
    }
}