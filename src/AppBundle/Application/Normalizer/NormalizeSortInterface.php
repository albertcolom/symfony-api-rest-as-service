<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface NormalizeSortInterface
{
    /**
     * @param $data
     * @return array
     */
    public function normalize($data);
}