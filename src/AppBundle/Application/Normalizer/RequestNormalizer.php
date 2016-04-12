<?php

namespace AppBundle\Application\Normalizer;

class RequestNormalizer implements RequestNormalizeInterface
{
    /**
     * @var NormalizeSort
     */
    private $normalizeSort;

    /**
     * @var RequestNormalizerData
     */
    private $requestNormalizerData;

    public function __construct(NormalizeSort $normalizeSort, RequestNormalizerData $requestNormalizerData)
    {
        $this->normalizeSort = $normalizeSort;
        $this->requestNormalizerData = $requestNormalizerData;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(array $params)
    {
        $offsetData = $this->checkAndGet($params, 'offset', requestNormalizerData::OFFSET);
        $this->requestNormalizerData->setOffset($offsetData);

        $limitData = $this->checkAndGet($params, 'limit', requestNormalizerData::LIMIT);
        $this->requestNormalizerData->setLimit($limitData);

        $fieldsData = $this->checkAndGet($params, 'fields', requestNormalizerData::FIELDS);
        $this->requestNormalizerData->setFields($fieldsData);

        $sortData = $this->checkAndGet($params, 'sort', requestNormalizerData::SORT);
        $sortNormalizer = $this->normalizeSort->normalize($sortData);
        $this->requestNormalizerData->setSort($sortNormalizer);

        $groupsData = $this->checkAndGet($params, 'groups', requestNormalizerData::GROUPS);
        $this->requestNormalizerData->setGroups($groupsData);

        return $this->requestNormalizerData;
    }

    /**
     * @param array $param
     * @param string $index
     * @param string $default
     * @return string
     */
    private function checkAndGet(array $param, $index, $default)
    {
        if (isset($param[$index]) && $param[$index] != null) {
            return $param[$index];
        }
        return $default;
    }
}