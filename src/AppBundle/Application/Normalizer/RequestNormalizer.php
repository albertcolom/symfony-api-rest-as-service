<?php

namespace AppBundle\Application\Normalizer;

class RequestNormalizer implements RequestNormalizeInterface
{
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
    private $goups;

    public function __construct()
    {
        $this->offset = 0;
        $this->limit = 20;
        $this->sort = [];
        $this->fields = [];
        $this->goups = ['Default'];
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
        $this->sort = $this->normalizeSort($this->checkAndGet($params, 'sort', $this->sort));

        return new RequestNormalizerData($this->offset, $this->limit, $this->sort, $this->fields, $this->goups);
    }

    /**
     * @param null $sortFields
     * @return array
     */
    private function normalizeSort($sortFields = null)
    {
        $sort = [];
        if($sortFields || !is_array($sortFields)) {
            foreach(explode(',', $sortFields) as $val){
                $key = preg_replace("/[^A-Za-z0-9]/", '', $val);
                $sort[$key] = strpos($val, '-', 0)=== 0 ? 'DESC' : 'ASC';
            }
        }
        return $sort;
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