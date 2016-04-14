<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
interface RequestNormalizeInterface
{
    /**
     * @param array $data
     * @return RequestNormalizerData
     */
    public function normalize(array $data);
}