<?php

namespace AppBundle\Application\Normalizer;

interface RequestNormalizeInterface
{
    /**
     * @param array $data
     * @return RequestNormalizerData
     */
    public function normalize(array $data);
}