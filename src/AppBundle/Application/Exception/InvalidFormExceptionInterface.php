<?php

namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface InvalidFormExceptionInterface
{
    /**
     * @return array|null
     */
    public function getForm();
}