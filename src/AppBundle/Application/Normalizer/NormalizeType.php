<?php

namespace AppBundle\Application\Normalizer;
use AppBundle\Application\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class NormalizeType implements NormalizeTypeInterface
{
    /**
     * @var array
     */
    private $availableTypes;

    public function __construct()
    {
        $this->availableTypes = [
            'boolean',
            'integer',
            'float',
            'string',
            'array',
            'object',
            'null'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getVarType($var)
    {
        return gettype($var);
    }

    /**
     * {@inheritdoc}
     */
    public function setVarType($var, $type)
    {
        $this->checkAvailableType($type);
        settype($var, $type);
        return $var;
    }

    /**
     * {@inheritdoc}
     */
    public function checkExpectedType($var, $expectedTypes)
    {
        $equalType = 0;
        if (!is_array($expectedTypes)) $expectedTypes = (array)$expectedTypes;

        foreach ($expectedTypes as $expectedType){
            if (strtolower(gettype($var)) == strtolower($expectedType)) {
                $equalType++;
            }
        }

        if ($equalType <= 0) {
            throw new InvalidTypeException('Invalid submitted data type', Response::HTTP_BAD_REQUEST, $var, $expectedTypes);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkAvailableType($type)
    {
        if (!in_array($type, $this->availableTypes )) {
            throw new InvalidTypeException('Unavailable data type', Response::HTTP_BAD_REQUEST, $type);
        }
        return true;
    }
}