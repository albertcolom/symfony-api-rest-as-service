<?php
namespace AppBundle\Util\Inflector;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

class NoPluralize implements InflectorInterface
{

    public function pluralize($word)
    {
        return $word;
    }
}
