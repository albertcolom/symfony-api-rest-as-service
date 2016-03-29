<?php

namespace AppBundle\Tests\Application\Normalizer;

use AppBundle\Application\Normalizer\NormalizeSort;

/**
 * @group Normalize
 */
class NormalizeSortTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NormalizeSort
     */
    private $normalizeSort;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->normalizeSort = new NormalizeSort();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->normalizeSort);
    }

    public function testNormalizeBlankGetDefaultValue()
    {
        $result = $this->normalizeSort->normalize();
        $this->assertEquals([],$result);
    }

    public function testSortAsc()
    {
        $result = $this->normalizeSort->normalize('foo');
        $expected = ['foo' => 'ASC'];
        $this->assertEquals($result, $expected);
    }

    public function testSortDesc()
    {
        $result = $this->normalizeSort->normalize('-foo');
        $expected = ['foo' => 'DESC'];
        $this->assertEquals($result, $expected);
    }

    public function testMultiSort()
    {
        $result = $this->normalizeSort->normalize('foo,-bar,-baz');
        $expected = [
            'foo' => 'ASC',
            'bar' => 'DESC',
            'baz' => 'DESC'
        ];
        $this->assertEquals($result, $expected);
    }

    public function testMultiSortWithSameColumnName()
    {
        $result = $this->normalizeSort->normalize('-foo,-bar,foo');
        $expected = [
            'bar' => 'DESC',
            'foo' => 'ASC'
        ];
        $this->assertEquals($result, $expected);
    }

}