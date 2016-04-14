<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface InvalidTypeExceptionInterface
{
    /**
     * @return string|null
     */
    public function getVar();

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @return string|null
     */
    public function getExpectedType();
}