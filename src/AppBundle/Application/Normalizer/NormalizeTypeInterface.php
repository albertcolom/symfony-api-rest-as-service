<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface NormalizeTypeInterface
{
    /**
     * @param $var
     * @return mixed
     */
    public function getVarType($var);

    /**
     * @param $var
     * @param $type
     * @return mixed
     */
    public function setVarType($var, $type);

    /**
     * @param $var
     * @param array|string $expectedTypes
     * @return mixed
     */
    public function checkExpectedType($var, $expectedTypes);

    /**
     * @param $type
     * @return mixed
     */
    public function checkAvailableType($type);
}