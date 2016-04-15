<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface NormalizeSortInterface
{
    /**
     * @param string $data
     * @return array
     */
    public function normalize($data = null);
}