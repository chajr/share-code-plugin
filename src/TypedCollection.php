<?php
namespace GrShareCode;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Countable;

/**
 * Class TypedCollection
 * @package GrShareCode
 */
class TypedCollection implements IteratorAggregate, Countable
{
    /** @var array */
    private $items = [];

    /** @var string */
    private $itemType;

    /**
     * @param string $itemType
     */
    public function setItemType($itemType)
    {
        if (empty($this->itemType)) {
            $this->itemType = $itemType;
        }
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param object $item
     */
    public function add($item)
    {
        $this->validateItemType($item);
        $this->append($item);
    }

    /**
     * @param object $item
     */
    private function append($item)
    {
        $this->items[] = $item;
    }

    /**
     * @param object $item
     * @throws InvalidArgumentException
     */
    private function validateItemType($item)
    {
        if (empty($this->itemType)) {
            $this->itemType = is_object($item) ? get_class($item) : '';
        }

        if (!$this->isItemValid($item)) {
            $exceptionMessage = 'Invalid collection item - ';
            $exceptionMessage .= !empty($this->itemType) ? $this->itemType.' ' : '';
            $exceptionMessage .= 'object expected, given: '.gettype($item);

            throw new InvalidArgumentException($exceptionMessage);
        }
    }

    /**
     * @param object $item
     * @return boolean
     */
    private function isItemValid($item)
    {
        return !empty($this->itemType) && is_object($item) && ($item instanceof $this->itemType);
    }

    public function clear()
    {
        $this->items = [];
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param object $item
     * @return boolean
     */
    public function contains($item)
    {
        return in_array($item, $this->items);
    }

    /**
     * @param Matcher $filter
     * @return mixed
     */
    public function filter(Matcher $filter)
    {
        $result = clone $this;
        $result->items = array_values(\array_filter($this->items, [$filter, 'matches']));

        return $result;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function get($index)
    {
        if (!isset($this->items[$index])) {
            return null;
        }

        return $this->items[$index];
    }

}
