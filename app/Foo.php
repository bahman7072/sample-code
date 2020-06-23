<?php
/**
 * Created by PhpStorm.
 * User: Bahman
 * Date: 22/04/2020
 * Time: 02:35 PM
 */

namespace App;


use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class Foo
 * @method static String doSomething($type, $name)
 *
 * @method  static Integer max($first, $second)
 */
class Foo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fooService';
    }
}