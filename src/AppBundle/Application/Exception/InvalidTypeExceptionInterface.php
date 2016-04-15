<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface InvalidTypeExceptionInterface
{
    /**
     * @return string
     */
    public function getVar();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getExpectedType();
}