<?php

namespace AppBundle\Application\Normalizer;

interface NormalizeSortInterface
{
    /**
     * @param $data
     * @return array
     */
    public function normalize($data);
}