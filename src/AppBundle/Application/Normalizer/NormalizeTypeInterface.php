<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface NormalizeTypeInterface
{
    /**
     * @param mixed $var
     * @return string
     */
    public function getVarType($var);

    /**
     * @param mixed $var
     * @param string $type
     * @return mixed
     */
    public function setVarType($var, $type);

    /**
     * @param mixed $var
     * @param array|string $expectedTypes
     * @return bool
     */
    public function checkExpectedType($var, $expectedTypes);

    /**
     * @param string $type
     * @return bool
     */
    public function checkAvailableType($type);
}
