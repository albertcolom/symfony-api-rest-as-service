<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface InvalidFormExceptionInterface
{
    /**
     * @return array
     */
    public function getForm();
}