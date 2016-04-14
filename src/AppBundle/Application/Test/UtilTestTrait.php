<?php

namespace AppBundle\Application\Test;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
trait UtilTestTrait
{
    /**
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     */
    public function getPrivateMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}