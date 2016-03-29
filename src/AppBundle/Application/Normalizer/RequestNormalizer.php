<?php

namespace AppBundle\Application\Normalizer;

class RequestNormalizer implements RequestNormalizeInterface
{
    /**
     * @var NormalizeSort
     */
    private $normalizeSort;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $sort;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $groups;

    /**
     * RequestNormalizer constructor.
     * @param NormalizeSort $normalizeSort
     */
    public function __construct(NormalizeSort $normalizeSort)
    {
        $this->normalizeSort = $normalizeSort;

        $this->offset = 0;
        $this->limit = 20;
        $this->sort = [];
        $this->fields = [];
        $this->groups = ['Default'];
    }

    /**
     * @param array $params
     * @return RequestNormalizerData
     */
    public function normalize(array $params)
    {
        $this->offset = $this->checkAndGet($params, 'offset', $this->offset);
        $this->limit = $this->checkAndGet($params, 'limit', $this->limit);
        $this->fields = $this->checkAndGet($params, 'fields', $this->fields);
        $this->sort = $this->normalizeSort->normalize($this->checkAndGet($params, 'sort', $this->sort));
        $this->groups = $this->checkAndGet($params, 'groups', $this->groups);

        return new RequestNormalizerData($this->offset, $this->limit, $this->sort, $this->fields, $this->groups);
    }

    /**
     * @param $param
     * @param $index
     * @param $default
     * @return mixed
     */
    private function checkAndGet($param, $index, $default)
    {
        if (isset($param[$index]) && $param[$index] != null) {
            return $param[$index];
        }
        return $default;
    }
}