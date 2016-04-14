<?php

namespace AppBundle\Application\Normalizer;

use AppBundle\Application\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
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
        $this->checkExpectedType($offsetData, 'integer');
        $this->requestNormalizerData->setOffset($offsetData);

        $limitData = $this->checkAndGet($params, 'limit', requestNormalizerData::LIMIT);
        $this->checkExpectedType($limitData, 'integer');
        $this->requestNormalizerData->setLimit($limitData);

        $fieldsData = $this->checkAndGet($params, 'fields', requestNormalizerData::FIELDS);
        $this->checkExpectedType($fieldsData, 'array');
        $this->requestNormalizerData->setFields($fieldsData);

        $sortData = $this->checkAndGet($params, 'sort', requestNormalizerData::SORT);
        $sortNormalizer = $this->normalizeSort->normalize($sortData);
        $this->requestNormalizerData->setSort($sortNormalizer);

        $groupsData = $this->checkAndGet($params, 'groups', requestNormalizerData::GROUPS);
        $this->checkExpectedType($groupsData, 'array');
        $this->requestNormalizerData->setGroups($groupsData);

        return $this->requestNormalizerData;
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

    /**
     * @param $var
     * @param $expectedType
     * @return bool
     * @throws \Exception
     */
    private function checkExpectedType($var, $expectedType)
    {
        if (strtolower(gettype($var)) !== strtolower($expectedType)) {
            throw new InvalidTypeException('Invalid submitted data type', Response::HTTP_BAD_REQUEST, $var, $expectedType);
        }

        return true;
    }
}