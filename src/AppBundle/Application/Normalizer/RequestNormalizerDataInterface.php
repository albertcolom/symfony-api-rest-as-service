<?php

namespace AppBundle\Application\Normalizer;

interface RequestNormalizerDataInterface
{
    /**
     * @return int
     */
    public function getOffset();

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @return array
     */
    public function getSort();

    /**
     * @return array
     */
    public function getFields();
}