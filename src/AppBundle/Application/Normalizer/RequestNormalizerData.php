<?php

namespace AppBundle\Application\Normalizer;

class RequestNormalizerData implements RequestNormalizerDataInterface
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
    private $groups;

    public function __construct($offset, $limit, array $sort, array $fields, array $groups)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->fields = $fields;
        $this->groups = $groups;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }
}