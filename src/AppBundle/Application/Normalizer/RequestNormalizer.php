<?php

namespace AppBundle\Application\Normalizer;

class RequestNormalizer implements RequestNormalizeInterface
{
    public function normalize(array $params)
    {
        $offset = $params['offset'];
        $limit = $params['limit'];
        $sort = $params['sort'];
        $fields = $params['fields'];

        return new RequestNormalizerData($offset, $limit, $sort, $fields);
    }
}