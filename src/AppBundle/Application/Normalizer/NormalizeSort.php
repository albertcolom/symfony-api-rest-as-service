<?php

namespace AppBundle\Application\Normalizer;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class NormalizeSort implements NormalizeSortInterface
{
    /**
     * @var array
     */
    private $sort;

    public function __construct()
    {
        $this->sort = [];
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($data = null)
    {
        if($data && !is_array($data)) {
            foreach(explode(',', $data) as $val){
                $key = preg_replace("/[^A-Za-z0-9]/", '', $val);
                $this->sort[$key] = strpos($val, '-', 0)=== 0 ? 'DESC' : 'ASC';
            }
        }
        return $this->sort;
    }
}