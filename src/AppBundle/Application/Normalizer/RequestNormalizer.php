<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class RequestNormalizer implements RequestNormalizerInterface
{
    /**
     * @var NormalizeSortInterface
     */
    private $normalizeSort;

    /**
     * @var NormalizeTypeInterface
     */
    private $normalizeType;

    /**
     * @var RequestNormalizerDataInterface
     */
    private $requestNormalizerData;

    public function __construct(NormalizeSortInterface $normalizeSort, NormalizeTypeInterface $normalizeType, RequestNormalizerDataInterface $requestNormalizerData)
    {
        $this->normalizeSort = $normalizeSort;
        $this->requestNormalizerData = $requestNormalizerData;
        $this->normalizeType = $normalizeType;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(array $params)
    {
        $this->normalizeOffset($params);
        $this->normalizeLimit($params);
        $this->normalizeSort($params);
        $this->normalizeGroups($params);

        return $this->requestNormalizerData;
    }

    /**
     * @param array $params
     */
    private function normalizeOffset(array $params)
    {
        $offsetData = $this->checkAndGet($params, 'offset', requestNormalizerData::OFFSET);
        $offsetDataType = $this->normalizeType->setVarType($offsetData, 'integer');
        $this->normalizeType->checkExpectedType($offsetDataType, 'integer');
        $this->requestNormalizerData->setOffset($offsetDataType);
    }

    /**
     * @param array $params
     */
    private function normalizeLimit(array $params)
    {
        $fieldsData = $this->checkAndGet($params, 'limit', requestNormalizerData::FIELDS);
        $fieldsDataType = $this->normalizeType->setVarType($fieldsData, 'integer');
        $this->normalizeType->checkExpectedType($fieldsDataType, 'integer');
        $this->requestNormalizerData->setLimit($fieldsDataType);
    }

    /**
     * @param array $params
     */
    private function normalizeSort(array $params)
    {
        $sortData = $this->checkAndGet($params, 'sort', requestNormalizerData::SORT);
        $sortNormalizer = $this->normalizeSort->normalize($sortData);
        $this->normalizeType->checkExpectedType($sortNormalizer, 'array');
        $this->requestNormalizerData->setSort($sortNormalizer);
    }

    /**
     * @param array $params
     */
    private function normalizeGroups(array $params)
    {
        $groupsData = $this->checkAndGet($params, 'groups', requestNormalizerData::GROUPS);
        $this->normalizeType->checkExpectedType($groupsData, 'array');
        $this->requestNormalizerData->setGroups($groupsData);
    }

    /**
     * @param array $param
     * @param string $index
     * @param string $default
     * @return string
     */
    private function checkAndGet(array $param, $index, $default = null)
    {
        if (isset($param[$index]) && $param[$index] != null) {
            return $param[$index];
        }
        return $default;
    }
}